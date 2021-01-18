<?php

namespace LaraAreaMake\Console\Commands;

use LaraAreaMake\Console\Abstracts\PhpMaker;

class MakeAll extends PhpMaker
{
    /**
     * @var string
     */
    public $commandName = 'all';

    /**
     * @var array
     */
    public $commands = [
        MakeModel::class,
    ];

    /**
     * @param $dbStructure
     * @param $content
     * @return bool|void
     */
    protected function makeBasedDb($dbStructure, $content)
    {
        $pattern = $this->initialArgument('pattern');
        foreach ($this->commands as $command) {
            $this->call($command, ['pattern' => $pattern, '--confirm' => true, '--choice-default' => true]);
        }
    }

    /**
     * @param null $key
     * @return array|string|null
     */
    public function initialArgument($key = null)
    {
        if (is_null($key)) {
            return $this->input->getArguments();
        }

        return $this->input->getArgument($key);
    }

//    /**
//     * @param null $key
//     * @return array|bool|string|null
//     * @throws \LaraAreaMake\Exceptions\LaraAreaCommandException
//     */
//    public function option($key = null)
//    {
//        if (is_null($key)) {
//            return $this->input->getOptions();
//        }
//
//        return parent::option($key); // TODO: Change the autogenerated stub
//    }
}