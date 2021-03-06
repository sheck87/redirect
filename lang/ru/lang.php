<?php return [
    'plugin' => [
        'name' => 'Редиректы',
        'description' => 'Удобное управление редиректами',
    ],
    'permission' => [
        'access_redirects' => [
            'label' => 'Редиректы',
            'tab' => 'Редиректы',
        ],
    ],
    'navigation' => [
        'menu_label' => 'Редиректы',
        'menu_description' => 'Управление редиректами',
    ],
    'redirect' => [
        'redirect' => 'Редиректы',
        'from_url' => 'Исходный путь',
        'from_url_placeholder' => '/source/path',
        'from_url_comment' => 'Исходный путь относительно корня сайта.',
        'to_url' => 'Путь редиректа или URL',
        'to_url_placeholder' => '/absolute/path, relative/path или http://target.url',
        'to_url_comment' => 'Абсолютный путь, относительный путь или URL для перенаправления.',
        'to_url_required_if' => 'Исходный путь или URL обязателен для заполнения',
        'cms_page_required_if' => 'Пожалуйста, выберите страницу CMS для перенаправления',
        'static_page_required_if' => 'Пожалуйста, пропишите статическую страницу для перенаправления',
        'match_type' => 'Тип соответствия',
        'exact' => 'Точный',
        'placeholders' => 'По меткам',
        'target_type' => 'Тип цели редиректа',
        'target_type_path_or_url' => 'Путь или URL',
        'target_type_cms_page' => 'Страница CMS',
        'target_type_static_page' => 'Статическая страница',
        'status_code' => 'Код HTTP-статуса',
        'sort_order' => 'Порядок сортировки',
        'requirements' => 'Параметры меток',
        'requirements_comment' => 'Добавьте параметры для каждого условия.',
        'placeholder' => 'Метка',
        'placeholder_comment' => 'Имя метки (включая фигурные скобки) проставленной в поле \'Исходный путь\'. Например, {category} или {id}',
        'requirement' => 'Параметры',
        'requirement_comment' => 'Пропишите параметры с помощью регулярных выражений. Например, [0-9]+ или [a-zA-Z]+.',
        'requirements_prompt' => 'Добавить новый параметр',
        'replacement' => 'Замена',
        'replacement_comment' => 'Пропишите (опционально) замену для текущей метки. В целевом URL метка будет заменена на это значение.',
        'permanent' => '301 - перемещено навсегда',
        'temporary' => '302 - перемещено временно',
        'see_other' => '303 - смотреть другое',
        'not_found' => '404 - не найдено',
        'gone' => '410 - удалено',
        'enabled' => 'Включено',
        'enabled_comment' => 'Сдвиньте переключатель для включения этого редиректа.',
        'priority' => 'Приоритет',
        'hits' => 'Переходы',
        'return_to_redirects' => 'Вернуться к списку редиректов',
        'return_to_categories' => 'Вернуться к списку категорий',
        'delete_confirm' => 'Вы уверены?',
        'created_at' => 'Создано в',
        'modified_at' => 'Изменено в',
        'system_tip' => 'Системный редирект',
        'user_tip' => 'Пользовательский редирект',
        'type' => 'Тип',
        'last_used_at' => 'Последнее использование',
        'and_delete_log_item' => 'И удалить выбранные элементы лога',
        'category' => 'Категория',
        'categories' => 'Категории',
        'name' => 'Имя',
        'date_time' => 'Дата и время',
        'date' => 'Дата',
        'truncate_confirm' => 'Вы уверены, что хотите удалить ВСЕ записи?',
        'truncating' => 'Удаление...',
    ],
    'list' => [
        'no_records' => 'В этом списке нет редиректов.',
        'switch_is_enabled' => 'Включено',
        'switch_system' => 'Системные редиректы',
    ],
    'scheduling' => [
        'from_date' => 'Дата включения',
        'from_date_comment' => 'Дата, с которой редирект будет активен. Не обязательное поле.',
        'to_date' => 'Дата выключения',
        'to_date_comment' => 'Дата, по которую редирект будет активен. Не обязательное поле.',
        'scheduling_comment' => 'Здесь вы можете задать период, в течении которого редирект будет активен. Возможны любые комбинации дат.',
    ],
    'test' => [
        'test_comment' => 'Пожалуйста, проверьте редирект перед сохранением.',
        'input_path' => 'Введите путь',
        'input_path_comment' => 'Путь для тестирование. Например, /old-blog/category/123',
        'input_path_placeholder' => '/input/path',
        'test_date' => 'Выберите дату',
        'test_date_comment' => 'Если вы запланировали редирект по расписанию, вы можете проверить его работу для конкретной даты.',
        'testing' => 'Проверка...',
        'run_test' => 'Запустить проверку',
        'no_match_label' => 'Извините, совпадения не найдены!',
        'no_match' => 'Совпадений не найдено!',
        'match_success_label' => 'Есть совпадение!',
    ],
    'title' => [
        'import' => 'Импорт',
        'export' => 'Экспорт',
        'redirects' => 'Управление редиректами',
        'create_redirect' => 'Создать редирект',
        'edit_redirect' => 'Редактировать редирект',
        'categories' => 'Управление категориями',
        'create_category' => 'Создать категорию',
        'edit_category' => 'Редактировать категорию',
        'view_redirect_log' => 'Смотреть лог редиректов',
        'statistics' => 'Статистика',
    ],
    'buttons' => [
        'add' => 'Добавить',
        'from_request_log' => 'Из лога запросов',
        'new_redirect' => 'Новый редирект',
        'create_redirects' => 'Создание редиректов',
        'delete' => 'Удалить',
        'enable' => 'Включить',
        'disable' => 'Отключить',
        'reorder_redirects' => 'Упорядочить',
        'export' => 'Экспортировать',
        'import' => 'Импортировать',
        'categories' => 'Категории',
        'new_category' => 'Новая категория',
        'reset_statistics' => 'Сбросить статистику',
        'logs' => 'Лог редиректов',
        'empty_redirect_log' => 'Очистить лог',
    ],
    'tab' => [
        'tab_general' => 'Основные',
        'tab_requirements' => 'Параметры меток',
        'tab_test' => 'Проверка',
        'tab_scheduling' => 'Расписание',
    ],
    'flash' => [
        'success_created_redirects' => 'Успешно создано :count редирект(ов)',
        'static_page_redirect_not_supported' => 'Этот редирект нельзя изменить. Необходим плагин RainLab.Pages.',
        'truncate_success' => 'Все записи успешно удалены',
        'delete_selected_success' => 'Выбранные записи успешно удалены',
    ],
];
