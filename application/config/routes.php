<?php

return [
  //MainController
  'blogg' => [
    'controller' => 'main',
    'action' => 'index',
  ],
  'blogg/tag/{page:\d+}(\?\w*=?\w*)?' => [
    'controller' => 'main',
    'action' => 'tag',
  ],
  'blogg/tag(\?\w*=?\w*)?' => [
    'controller' => 'main',
    'action' => 'tag',
  ],
  'blogg/about' => [
    'controller' => 'main',
    'action' => 'about',
  ],
  'blogg/contact' => [
    'controller' => 'main',
    'action' => 'contact',
  ],
  'blogg/login(\?post=\d+)?' => [
    'controller' => 'main',
    'action' => 'login',
  ],
  'blogg/register' => [
    'controller' => 'main',
    'action' => 'register',
  ],
  'blogg/logout' => [
    'controller' => 'main',
    'action' => 'logout',
  ],
  'blogg/post/{id:\d+}' => [
    'controller' => 'main',
    'action' => 'post',
  ],
  'blogg/author/{id:\d+}' => [
    'controller' => 'main',
    'action' => 'author',
  ],
  'blogg/profile/dashboard' => [
    'controller' => 'main',
    'action' => 'dashboard',
  ],
  'blogg/profile/settings' => [
    'controller' => 'main',
    'action' => 'settings',
  ],
  'blogg/profile/notifications' => [
    'controller' => 'main',
    'action' => 'notifications',
  ],
  //AdminController
  'blogg/admin/login' => [
    'controller' => 'admin',
    'action' => 'login',
  ],
  'blogg/admin/logout' => [
    'controller' => 'admin',
    'action' => 'logout',
  ],
  'blogg/admin/add' => [
    'controller' => 'admin',
    'action' => 'add',
  ],
  'blogg/admin/delete/{id:\d+}' => [
    'controller' => 'admin',
    'action' => 'delete',
  ],
  'blogg/admin/edit/{id:\d+}' => [
    'controller' => 'admin',
    'action' => 'edit',
  ],
  'blogg/admin/posts/{page:\d+}' => [
    'controller' => 'admin',
    'action' => 'posts',
  ],
  'blogg/admin/posts' => [
    'controller' => 'admin',
    'action' => 'posts',
  ],
  'blogg/admin/users/{page:\d+}' => [
    'controller' => 'admin',
    'action' => 'users',
  ],
  'blogg/admin/users' => [
    'controller' => 'admin',
    'action' => 'users',
  ],
  'blogg/admin/messages' => [
    'controller' => 'admin',
    'action' => 'messages',
  ],
  'blogg/admin/messages/{id:\d+}' => [
    'controller' => 'admin',
    'action' => 'message',
  ],
  'blogg/admin/messages/delete/{id:\d+}' => [
    'controller' => 'admin',
    'action' => 'messageDelete',
  ],
  'blogg/admin/user/{id:\d+}' => [
    'controller' => 'admin',
    'action' => 'user',
  ],
  'blogg/admin/user/remove/{id:\d+}' => [
    'controller' => 'admin',
    'action' => 'remove',
  ],
    //EditorController
    'blogg/editor/add' => [
      'controller' => 'editor',
      'action' => 'add',
    ],
    'blogg/editor/delete/{id:\d+}' => [
      'controller' => 'editor',
      'action' => 'delete',
    ],
    'blogg/editor/edit/{id:\d+}' => [
      'controller' => 'editor',
      'action' => 'edit',
    ],
    'blogg/editor/posts/{page:\d+}' => [
      'controller' => 'editor',
      'action' => 'posts',
    ],
    'blogg/editor/posts' => [
      'controller' => 'editor',
      'action' => 'posts',
    ],
];
