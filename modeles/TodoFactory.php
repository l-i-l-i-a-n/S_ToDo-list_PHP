<?php

namespace modeles;

/**
 * Class TodoFactory
 * @package modeles
 */
class TodoFactory
{
    /**
     * @param array $results
     * @param string $type
     * @return array
     */
    public function createTodos(array $results, string $type) : array
    {
        if ($type == 'mysql')
        {
            $tab = array();
            foreach ($results as $row) {
                $tab[] = new Todo($row['id'], $row['description'], $row['isDone'], $row['idList']);
            }
            return $tab;
        }
        else
            return array();
    }
}