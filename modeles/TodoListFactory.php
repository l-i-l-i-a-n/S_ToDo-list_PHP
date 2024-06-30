<?php

namespace modeles;

/**
 * Class TodoListFactory
 * @package modeles
 */
class TodoListFactory
{
    /**
     * @param array $results
     * @param string $type
     * @return array
     */
    public function createTodolists(array $results, string $type) : array
    {
        if ($type == 'mysql')
        {
            $tab = array();
            foreach ($results as $row) {
                $tab[] = new TodoList($row['id'], $row['title'], $row['isPublic'], $row['idUser']);
            }
            return $tab;
        }
        else
            return array();
    }
}