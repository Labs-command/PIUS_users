<?php

namespace App\Http\Controllers;

class ViewsController
{
    public function userPage()
    {
        $tasks = array(
            array(
                'id' => '1',
                'subject' => 'Task subject',
                'text' => 'Large text of task. Lorem ipsum dolor sit am ea commodo sed diam nonum et justo ut aliquet lore',
                'date_added' => '31.03.2024',
                'answer' => 'You are fall',
                'author' => array(
                    'id' => 1,
                    'name' => 'Name ???'
                ),
            ),
            array(
                'id' => '2',
                'subject' => 'Task subject 2',
                'text' => 'Large text of tasksdfljsd;ofj;sdlfjlksadhflsdzf. Lorem joigggggggggggsdfffffffffffffffffffffffsipsum dolor sit am ea commodo sed diam nonum et justo ut aliquet lore',
                'date_added' => '31.03.2024',
                'answer' => 'You are cat:3',
                'author' => array(
                    'id' => 2,
                    'name' => 'Name ???'
                ),
            ),
        );
        return view('tasks', ['tasks' => $tasks]);
    }
    public function moderatorPage()
    {
        $tasks = array(
            array(
                'id' => '1',
                'subject' => 'Task subject',
                'text' => 'Large text of task. Lorem ipsum dolor sit am ea commodo sed diam nonum et justo ut aliquet lore',
                'date_added' => '31.03.2024',
                'author' => array(
                    'id' => 1,
                    'name' => 'Name ???'
                ),
            ),
            array(
                'id' => '2',
                'subject' => 'Task subject 2',
                'text' => 'Large text of tasksdfljsd;ofj;sdlfjlksadhflsdzf. Lorem joigggggggggggsdfffffffffffffffffffffffsipsum dolor sit am ea commodo sed diam nonum et justo ut aliquet lore',
                'date_added' => '31.03.2024',
                'author' => array(
                    'id' => 2,
                    'name' => 'Name ???'
                ),
            ),
        );
        return view('moderator', ['tasks' => $tasks]);
    }
}
