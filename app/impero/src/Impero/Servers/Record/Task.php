<?php namespace Impero\Servers\Record;

use Impero\Servers\Entity\Tasks;
use Pckg\Database\Entity;
use Pckg\Database\Record;
use Throwable;

class Task extends Record
{

    protected $entity = Tasks::class;

    public static function create($data = [], Entity $entity = null)
    {
        /**
         * Get current task.
         */
        $parentTask = context()->getOrDefault(Task::class);

        /**
         * If title was passed, transform it.
         */
        if (is_string($data)) {
            $data = ['title' => $data];
        }

        /**
         * Create task in database.
         */
        $task = parent::create(
            array_merge(
                $data, [
                         'parent_id' => $parentTask->id ?? null,
                         'status'    => 'created',
                     ]
            ),
            $entity
        );

        /**
         * Bind it as current.
         */
        context()->bind(Task::class, $task);
    }

    public function end()
    {
        $this->setAndSave(['ended_at' => date('Y-m-d H:i:s')]);
        context()->bind(Task::class, $this->parent);
    }

    /**
     * @param callable $make
     *
     * @throws Throwable
     */
    public function make(callable $make, callable $exception = null)
    {
        try {
            /**
             * Try to execute task.
             */
            $this->setAndSave(['status' => 'started', 'started_at' => date('Y-m-d H:i:s')]);
            $result = $make();
            $this->set(['status' => 'ended']);
            $this->end();
            return $result;
        } catch (Throwable $e) {
            /**
             * If any exception is thrown, mark task as failed.
             */
            $this->set(['status' => 'error']);
            $this->end();
            if ($exception) {
                return $exception($this);
            }

            throw $e;
        }
    }

}