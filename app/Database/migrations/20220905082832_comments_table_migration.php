<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Table\Column;

final class CommentsTableMigration extends AbstractMigration
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

        $table = $this->table('comments', $options);
        $table->addColumn($column)
            ->addColumn('comment', 'text')
            ->addColumn('article_id', 'biginteger')
            ->addColumn('author', 'biginteger')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addForeignKey('article_id', 'articles', 'id', array('delete' => 'NO_ACTION', 'update' => 'NO_ACTION'))
            ->addForeignKey('author', 'users', 'id', array('delete' => 'NO_ACTION', 'update' => 'NO_ACTION'))
            ->create();
    }
}