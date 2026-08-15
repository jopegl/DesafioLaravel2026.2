@include('admin.people._list', [
'people' => $admins,
'prefix' => 'admins',
'urlBase' => route('admins.index'),
'singular' => 'administrador',
'pluralTitle' => 'Administradores cadastrados',
])