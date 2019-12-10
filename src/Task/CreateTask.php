<?php
declare (strict_types=1);

namespace Task;

class CreateTask extends \Phalcon\Cli\Task
{
    static public $limit = 100000;

    public function mainAction()
    {
        var_dump([
            'actions' => [
                'pdo',
                'phalcon',
                'maleficarum',
                'doctrine',
            ]
        ]);
    }

    public function pdoAction()
    {
        /** @var \PDO $connection */
        $connection = $this->getDI()->get('pdo');

        $start = microtime(true);
        $sql = 'INSERT INTO voucher ("voucher", "createdDatetime") VALUES (:voucher, :datetime)';

        $stm = $connection->prepare($sql);
        for ($i = 0; $i < self::$limit; $i++) {
            $stm->execute([
                'voucher' => md5(\uniqid()),
                'datetime' => \date('Y-m-d H:i:s')
            ]);
        }
        $end = microtime(true);

        var_dump([
            'time' => $end - $start . 'sek',
            'records' => self::$limit,
            'score' => self::$limit / ($end - $start) . ' row/sek',
            'memory' => memory_get_usage(true)
        ]);
    }


    public function phalconAction()
    {
        $start = microtime(true);

        $voucher = new \Model\Voucher();
        for ($i = 0; $i < self::$limit; $i++) {
            $voucher->id = null;
            $voucher->voucher = md5(\uniqid());
            $voucher->createdDatetime = \date('Y-m-d H:i:s');
            $voucher->create();
        }

        $end = microtime(true);

        var_dump([
            'time' => $end - $start . 'sek',
            'records' => self::$limit,
            'score' => self::$limit / ($end - $start) . ' row/sek',
            'memory' => memory_get_usage(true)
        ]);
    }


    public function maleficarumAction()
    {
        $start = microtime(true);

        $voucher = new \Data\Voucher\Entity();
        $repo = $this->getDI()->get('maleficarumRepo');

        for ($i = 0; $i < self::$limit; $i++) {
            //$voucher->setId($i++);
            $voucher->setVoucher(md5(\uniqid()));
            $voucher->setCreatedDatetime(\date('Y-m-d H:i:s'));
            $repo->create($voucher);
        }

        $end = microtime(true);

        var_dump([
            'time' => $end - $start . 'sek',
            'records' => self::$limit,
            'score' => self::$limit / ($end - $start) . ' row/sek',
            'memory' => memory_get_usage(true)
        ]);
    }


    public function doctrineAction()
    {
        $start = microtime(true);

        /** @var \Doctrine\ORM\EntityManager $repo */
        $repo = $this->getDI()->get('doctrine');

        for ($i = 0; $i < self::$limit; $i++) {
            $voucher = new \Doctrine\Voucher();
            $voucher->setVoucher(md5(\uniqid()));
            $voucher->setCreatedDatetime(new \DateTime());
            $repo->persist($voucher);
        }
        $repo->flush();
        $end = microtime(true);

        var_dump([
            'time' => $end - $start . 'sek',
            'records' => self::$limit,
            'score' => self::$limit / ($end - $start) . ' row/sek',
            'memory' => memory_get_usage(true)
        ]);
    }

    public function readAction()
    {
        $start = microtime(true);

        $a = \Model\Voucher::find([
            'hydration' => \Phalcon\Mvc\Model\Resultset::HYDRATE_ARRAYS
        ]);

        var_dump($a->getFirst());

        $end = microtime(true);
        var_dump([
            'time' => $end - $start . 'sek',
            'limit' => $a->count(),
            'memory' => memory_get_usage(true)
        ]);
    }

    public function updateAction()
    {
        echo 'update' . PHP_EOL;
    }

    public function deleteAction()
    {
        echo 'delete' . PHP_EOL;
    }
}