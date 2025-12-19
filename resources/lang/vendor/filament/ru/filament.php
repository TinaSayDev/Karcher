<?php

return [

    'actions' => [
        'create' => [
            'label' => 'Добавить',
        ],
        'edit' => [
            'label' => 'Редактировать',
        ],
        'delete' => [
            'label' => 'Удалить',
            'modal' => [
                'heading' => 'Удалить запись?',
                'subheading' => 'Это действие нельзя отменить.',
                'button' => 'Удалить',
            ],
        ],
        'save' => [
            'label' => 'Сохранить',
        ],
        'cancel' => [
            'label' => 'Отмена',
        ],
        'view' => [
            'label' => 'Просмотр',
        ],
    ],

    'table' => [
        'actions' => 'Действия',
        'empty' => 'Нет записей',
        'filters' => [
            'title' => 'Фильтры',
            'reset' => 'Сбросить фильтры',
        ],
    ],

    'widgets' => [
        'data' => [
            'label' => 'Данные',
        ],
    ],

    'global_search' => [
        'placeholder' => 'Поиск...',
    ],

    'pagination' => [
        'label' => 'Навигация',
        'overview' => 'Показано :first - :last из :total записей',
        'records_per_page' => 'Записей на странице: :count',
    ],

    'notifications' => [
        'empty' => 'Нет уведомлений',
    ],

    'pages' => [
        'dashboard' => [
            'label' => 'Панель управления',
        ],
    ],

    'forms' => [
        'actions' => [
            'submit' => [
                'label' => 'Сохранить',
            ],
        ],
    ],

];
