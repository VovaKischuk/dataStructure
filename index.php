<?php


class Sort
{
    public static int $bubbleIteration = 0;
    public static int $quickIteration = 0;

    static function bubble(array $sortArr, bool $back = false): array
    {
        $array_count = count($sortArr);

        for ($x = 0; $x < $array_count; $x++) {
            for ($a = 0; $a < $array_count - 1; $a++) {
                if ($a < $array_count) {
                    if ($sortArr[$a] > $sortArr[$a + 1] && !$back) {
                        [$sortArr[$a], $sortArr[$a + 1]] = [$sortArr[$a + 1], $sortArr[$a]];
                        Sort::$bubbleIteration++;
                    } elseif ($sortArr[$a] < $sortArr[$a + 1] && $back) {
                        [$sortArr[$a], $sortArr[$a + 1]] = [$sortArr[$a + 1], $sortArr[$a]];
                        Sort::$bubbleIteration++;
                    }
                }
            }
        }

        return $sortArr;
    }

    static function quick(array $array, bool $back = false): array
    {
        $length = count($array);

        if ($length <= 1) {
            return $array;
        } else {
            $pivot = $array[$length - 1];
            $left = array();
            $right = array();

            for ($i = 0; $i < $length - 1; $i++) {
                if(!$back) {
                    if ($array[$i] < $pivot) {
                        $left[] = $array[$i];
                        Sort::$quickIteration++;
                    } else {
                        $right[] = $array[$i];
                    }
                } else {
                    if ($array[$i] < $pivot) {
                        $right[] = $array[$i];
                        Sort::$quickIteration++;
                    } else {
                        $left[] = $array[$i];
                    }
                }

            }

            return array_merge(self::quick($left, $back), array($pivot), self::quick($right, $back));
        }
    }
}

class UserArray {

    static function generate(int $count): void
    {
        $arrayWithRandomValue = array_map(function () {
            return rand(0, 100);
        }, array_fill(0, $count, null));

        echo 'Generate array => ';
        self::printArray($arrayWithRandomValue, 0);

        echo 'Bubble sort array => ';
        self::printArray(Sort::bubble($arrayWithRandomValue), Sort::$bubbleIteration);

        Sort::$bubbleIteration = 0;
        echo 'Bubble sort back array => ';
        self::printArray(Sort::bubble($arrayWithRandomValue, true), Sort::$bubbleIteration);

        echo 'Quick sort array => ';
        self::printArray(Sort::quick($arrayWithRandomValue), Sort::$quickIteration);

        Sort::$quickIteration = 0;
        echo 'Quick sort back array => ';
        self::printArray(Sort::quick($arrayWithRandomValue, true), Sort::$quickIteration);
    }

    static function input(int $count): void
    {
        $arrayWithRandomValue = [];

        echo 'Please enter the array ';

        for($i = 0; $i < $count; $i++) {
            $arrayWithRandomValue[] = readline();
        }

        echo 'Your array => ';
        self::printArray($arrayWithRandomValue, 0);

        echo 'Bubble sort array => ';
        self::printArray(Sort::bubble($arrayWithRandomValue), Sort::$bubbleIteration);
        Sort::$bubbleIteration = 0;

        echo 'Bubble sort back array => ';
        self::printArray(Sort::bubble($arrayWithRandomValue, true), Sort::$bubbleIteration);

        echo 'Quick sort array => ';
        self::printArray(Sort::quick($arrayWithRandomValue), Sort::$quickIteration);
        Sort::$quickIteration = 0;

        echo 'Quick sort back array => ';
        self::printArray(Sort::quick($arrayWithRandomValue, true), Sort::$quickIteration);
    }

    static private function printArray(array $sortArr, int $iteration): void
    {
        echo '[';

        foreach ($sortArr as $item) {
            echo $item;
            echo ' ';
        }

        echo '] => (ITERATION) => '. $iteration . PHP_EOL;
    }

}

function quickCheckCount(mixed $count): bool
{
    if ( filter_var($count, FILTER_VALIDATE_INT) === false ) {
        echo 'Your variable is not an integer'. PHP_EOL;
        return true;
    }

    if ($count <= 1) {
        echo 'Please enter posit number'. PHP_EOL;
        return true;
    }

    return false;
}

$userArray = [];

echo 'Please enter value: '. PHP_EOL.'1 => generate value '. PHP_EOL.'2 => input value'. PHP_EOL;
$menu = readline();

do {
    echo 'Please enter count element in array:'. PHP_EOL;
    $count = readline();
} while(quickCheckCount($count));

match ((int)$menu) {
    1 => UserArray::generate($count),
    2 => UserArray::input($count),
    default => throw new \Exception('Unexpected match value')
};
