<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

final class UsersTableMigration extends AbstractMigration
{
    public function change(): void
    {
        $column = new Column();
        $column->setName('id')
            ->setType('biginteger')
            ->setIdentity(true);

        $options = array(
            'id'          => false,
            'primary_key' => 'id'
        );

        $table = $this->table('users', $options);
        $table->addColumn($column)
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('email', 'string', ['null' => false])
            ->addColumn('password', 'string', ['null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}