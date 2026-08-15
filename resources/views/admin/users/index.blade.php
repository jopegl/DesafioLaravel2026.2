@include('admin.people._list', [
'people' => $users,
'prefix' => 'users',
'urlBase' => route('users.index'),
'singular' => 'usuário',
'pluralTitle' => 'Usuários cadastrados',
])