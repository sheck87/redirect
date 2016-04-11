<?php

namespace Adrenth\Redirect\Classes;

use Adrenth\Redirect\Models\Redirect;
use Carbon\Carbon;
use InvalidArgumentException;
use League\Csv\Reader;
use Log;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RedirectManager
 *
 * @package Adrenth\Redirect\Classes
 */
class RedirectManager
{
    /** @type string */
    private $redirectRulesPath;

    /** @type RedirectRule[] */
    private $redirectRules;

    /** @type Carbon */
    private $matchDate;

    /**
     * Constructs a RedirectManager instance
     */
    protected function __construct()
    {
        $this->matchDate = Carbon::now();
    }

    /**
     * @param $redirectRulesPath
     * @return RedirectManager
     */
    public static function createWithRulesPath($redirectRulesPath)
    {
        $instance = new self();
        $instance->redirectRulesPath = $redirectRulesPath;
        return $instance;
    }

    /**
     * @param RedirectRule $rule
     * @return RedirectManager
     */
    public static function createWithRule(RedirectRule $rule)
    {
        $instance = new self();
        $instance->redirectRules[] = $rule;
        return $instance;
    }

    /**
     * Find a match based on given URL
     *
     * @param string $url
     * @return RedirectRule|false
     */
    public function match($url)
    {
        $this->loadRedirectRules();

        foreach ($this->redirectRules as $rule) {
            if ($matchedRule = $this->matchesRule($rule, $url)) {
                return $matchedRule;
            }
        }

        return false;
    }

    /**
     * Redirect with specific rule
     *
     * @param RedirectRule $rule
     * @return void
     */
    public function redirectWithRule(RedirectRule $rule)
    {
        try {
            /** @type Redirect $redirect */
            $redirect = Redirect::find($rule->getId());
            $redirect->setAttribute('hits', $redirect->getAttribute('hits') + 1);
            $redirect->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        if ($rule->getStatusCode() === 404) {
            abort($rule->getStatusCode(), 'Not Found');
        }

        header('Location: ' . $rule->getToUrl(), true, $rule->getStatusCode());

        exit();
    }

    /**
     * Change the match date; can be used to perform tests
     *
     * @param Carbon $matchDate
     * @return $this
     */
    public function setMatchDate(Carbon $matchDate)
    {
        $this->matchDate = $matchDate;
        return $this;
    }

    /**
     * @param RedirectRule $rule
     * @param string $url
     * @return RedirectRule|bool
     */
    private function matchesRule(RedirectRule $rule, $url)
    {
        // 1. Check if rule matches period
        if (!$this->matchesPeriod($rule)) {
            return false;
        }

        // 2. Perform exact match if applicable
        if ($rule->isExactMatchType()) {
            return $this->matchExact($rule, $url);
        }

        // 3. Perform placeholders match if applicable
        if ($rule->isPlaceholdersMatchType()) {
            return $this->matchPlaceholders($rule, $url);
        }

        return false;
    }

    /**
     * Perform an exact URL match
     *
     * @param RedirectRule $rule
     * @param string $url
     * @return RedirectRule|bool
     */
    private function matchExact(RedirectRule $rule, $url)
    {
        return $url === $rule->getFromUrl() ? $rule : false;
    }

    /**
     * Perform a placeholder URL match
     *
     * @param RedirectRule $rule
     * @param string $url
     * @return RedirectRule|bool
     */
    private function matchPlaceholders(RedirectRule $rule, $url)
    {
        $route = new Route($rule->getFromUrl());

        foreach ($rule->getRequirements() as $requirement) {
            try {
                $route->setRequirement(
                    str_replace(['{', '}'], '', $requirement['placeholder']),
                    $requirement['requirement']
                );
            } catch (\InvalidArgumentException $e) {
                // Catch empty requirement / placeholder
            }
        }

        $routeCollection = new RouteCollection();
        $routeCollection->add($rule->getId(), $route);

        try {
            $matcher = new UrlMatcher($routeCollection, new RequestContext('/'));
            $match = $matcher->match($url);

            $items = array_except($match, '_route');

            foreach ($items as $key => $value) {
                $placeholder = '{' . $key . '}';
                $replacement = $this->findReplacementForPlaceholder($rule, $placeholder);
                $items[$placeholder] = $replacement === null ? $value : $replacement;
                unset($items[$key]);
            }

            $toUrl = str_replace(
                array_keys($items),
                array_values($items),
                $rule->getToUrl()
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

        try {
            return new RedirectRule([
                $rule->getId(),
                $rule->getMatchType(),
                $rule->getFromUrl(),
                $toUrl,
                $rule->getStatusCode(),
                json_encode($rule->getRequirements()),
                $rule->getFromDate(),
                $rule->getToDate(),
            ]);
        } catch (\InvalidArgumentException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Check if rule matches a period
     *
     * @param RedirectRule $rule
     * @return bool
     */
    private function matchesPeriod(RedirectRule $rule)
    {
        /** @type Carbon $fromDate */
        $fromDate = ($rule->getFromDate() instanceof Carbon) ? $rule->getFromDate() : clone $this->matchDate;
        /** @type Carbon $toDate */
        $toDate = ($rule->getToDate() instanceof Carbon) ? $rule->getToDate() : clone $this->matchDate;

        return $this->matchDate->between($fromDate, $toDate);
    }

    /**
     * Find replacement value for placeholder
     *
     * @param RedirectRule $rule
     * @param string $placeholder
     * @return string|null
     */
    private function findReplacementForPlaceholder(RedirectRule $rule, $placeholder)
    {
        foreach ($rule->getRequirements() as $requirement) {
            if ($requirement['placeholder'] === $placeholder && !empty($requirement['replacement'])) {
                return (string) $requirement['replacement'];
            }
        }

        return null;
    }

    /**
     * Load definitions into memory
     *
     * @return RedirectRule[]
     */
    private function loadRedirectRules()
    {
        if ($this->redirectRules !== null) {
            return;
        }

        $rules = [];

        try {
            $reader = Reader::createFromPath($this->redirectRulesPath);

            foreach ($reader as $row) {
                $rules[] = new RedirectRule($row);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        $this->redirectRules = $rules;
    }
}
