<?php
/**
 * PSR-2 Interface
 * Если нужна память, то просто удаляем ненужную функциональность
 */
interface LoggerInterface
{
    public function error($message, array $context = array());
    /*public function emergency($message, array $context = array());
    public function alert($message, array $context = array());
    public function critical($message, array $context = array());
    public function warning($message, array $context = array());
    public function notice($message, array $context = array());
    public function info($message, array $context = array());
    public function debug($message, array $context = array());
    public function log($level, $message, array $context = array());*/
}

/**
 * Логер
 */
class Logger implements LoggerInterface
{
    /**
     * Просто выведем ошибку
     *
     * @param [type] $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = array())
    {
        echo"\n".$message;
    }
    
    /*public function emergency($message, array $context = array()){;}
    public function alert($message, array $context = array()){;}
    public function critical($message, array $context = array()){;}
    public function warning($message, array $context = array()){;}
    public function notice($message, array $context = array()){;}
    public function info($message, array $context = array()){;}
    public function debug($message, array $context = array()){;}
    public function log($level, $message, array $context = array()){;}*/
}

class Sequence
{
    /**
     * Кол-во максимальных чисел
     * 
     * @var [int]
     */
    private int $count_max_values;

    /**
     * Массив натуральных чисел
     *
     * @var [array]
     */
    private array $arr_numbers;

    /**
     * Массив максимальных натуральных чисел
     *
     * @var [array]
     */
    private array $max_numbers;

    /**
     * Logger
     *
     * @var [LoggerInterface]
     */
    private $logger;
    
    /**
     * Кол-во элементов натуральных чисел, чтобы несколько раз не вычислять
     * 
     *  @var [int]
     */
    private $count_arr_numbers;

    function __construct(array $m, int $n = 1, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->arr_numbers = $m;
        $this->count_max_values = $n;
    }

    /**
     * Валидация
     *
     * @return void or bool
     */
    private function validation()
    {
        if(($this->count_arr_numbers = count($this->arr_numbers)) < 1) {
            $this->logger->error("Массив чисел пустой");
            return 'error';
        }

        if($this->count_max_values < 1) {
            $this->logger->error("Недопустимое число максимальных чисел");
            return 'error';
        }

        if($this->count_max_values > $this->count_arr_numbers) {
            $this->logger->error("Кол-во максимальных чисел выше кол-ва натуральных чисел");
            return 'error';
        }
        return TRUE;
    }

    public function getMaxNumbers()
    {
        //проверяем
        if($this->validation() === 'error') return FALSE;
        //Сортируем и срезаем нужное кол-во
        sort($this->arr_numbers, SORT_NATURAL);
        $srez = $this->count_arr_numbers - $this->count_max_values;
        $this->max_numbers = array_slice($this->arr_numbers, $srez);

        return $this->max_numbers;
    }
}

$logger = new Logger;
$obj = new Sequence([7,7,5,5,2,3], 3, $logger);
var_dump($obj->getMaxNumbers());