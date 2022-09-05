<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

final class ArticlesTableMigration extends AbstractMigration
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

        $table = $this->table('articles', $options);
        $table->addColumn($column)
            ->addColumn('subject', 'string')
            ->addColumn('content', 'text')
            ->addColumn('author', 'biginteger')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey('author', 'users', 'id', array('delete' => 'NO_ACTION', 'update' => 'NO_ACTION'))
            ->create();
    }
}