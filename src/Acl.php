<?php

namespace Unit;

use Unit\Acl\AccessDenied;
use Unit\Acl\PrivilegeUndefined;
use Unit\Acl\ResourceUndefined;

class Acl
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function check($resource, $privilege, $role)
    {
        if (!array_key_exists($resource, $this->data)) {
            throw new ResourceUndefined();
        }

        if (!array_key_exists($privilege, $this->data[$resource])) {
            throw new PrivilegeUndefined();
        }

        $roles = $this->data[$resource][$privilege];
        if (!in_array($role, $roles)) {
            throw new AccessDenied('Access denied');
        }
    }
}
$data = [
    'articles' => [
        'show' => ['editor', 'manager'],
        'edit' => ['editor']
    ],
    'money' => [
        'create' => ['editor'],
        'show' => ['editor', 'manager'],
        'edit' => ['manager'],
        'remove' => ['manager']
    ]
];
$a = new Acl($data);