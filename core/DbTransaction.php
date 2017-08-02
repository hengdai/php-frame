<?php

/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/15
 * Time: 16:02
 */
class DbTransaction extends Model
{
    protected $logic;
    protected $pdo;

    function __construct($logic)
    {
        $this->logic = $logic;
        $this->pdo = Model::getPdoInstance();
    }

    public static function run($logic)
    {
        $instance = new self($logic);
        $instance->runTransaction();
    }

    function runTransaction()
    {
        $this->assertNotInTransaction();
        $this->pdo->beginTransaction();

        try {
            call_user_func($this->logic, $this);
            $result = $this->pdo->commit();
            if (!$result) {
                throw new PDOException();
            }
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            Log::debug('DbTransactionError', [$e]);
            throw $e;
        }
    }

    //断言,当前不在事务中，否则抛错
    function assertNotInTransaction()
    {
        if (!$this->pdo->inTransaction()) {
            return true;
        }

        throw new Exception();
    }
}