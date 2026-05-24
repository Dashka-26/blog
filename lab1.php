<?php
//завдання 1
$arr1 = [2, 3, 4, 5];
$result1 = array_product($arr1);
echo $result1 . "\n";

//завдання 2
$arr2 = [28, 496, 999, 6, 51];
for ($i = 0; $i < 15; $i++) {
    $arr2[] = rand(1, 1000);
}
foreach ($arr2 as $num2){
    if ($num2 < 2){
        continue;
    }
    $sum2 = 0;
    for ($j = 1; $j <= $num2 / 2; $j++) {
        if ($num2 % $j == 0) {
            $sum2 += $j;
        }
    }

    if ($sum2 == $num2) {
        echo $num2 . "\n";
    }
}

//завдання 3
$arr3 = [4, 0, "0", 10, 0, 7];
$count3 = 0;
foreach ($arr3 as $num3) {
    if ($num3 === 0) {
        $count3++;
    }
}
echo $count3 . "\n";

//завдання 4
$arr4 = [];
for ($i = 0; $i < 20; $i++) {
    $arr4[] = rand(1, 50);
}
$sum4 = 0;
foreach ($arr4 as $num4) {
    if ($num4 % 2 !== 0) {
        $sum4 += $num4 ** 2;
    }
}

echo $sum4 . "\n";

//завдання 5
$arr5 = [];
for ($i = 0; $i < 8; $i++) {
    $arr5[] = rand(1, 100);
}
echo "До: " . implode(", ", $arr5) . "\n";
$last = count($arr5) - 1;
$temp = $arr5[0];
$arr5[0] = $arr5[$last];
$arr5[$last] = $temp;
echo "Після: " . implode(", ", $arr5) . "\n";

//завдання 6
$arr6 = [];
for ($i = 0; $i < 10; $i++) {
    $arr6[] = rand(-50, 50);
}
$sum6 = 0;
$count6 = 0;
foreach ($arr6 as $num6) {
    if ($num6 > 0) {
        $sum6 += $num6;
        $count6++;
    }
}
if ($count6 > 0) {
    $average6 = $sum6 / $count6;
    echo $average6 . "\n";
} else {
    echo "Додатних чисел немає\n";
}

//завдання 7
$name7 = "Гарбузюк Олег";
$lower7 = mb_strtolower($name7, 'UTF-8');
$translit7 = [
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'h', 'ґ' => 'g',
    'д' => 'd', 'е' => 'e', 'є' => 'ye', 'ж' => 'zh', 'з' => 'z',
    'и' => 'y', 'і' => 'i', 'ї' => 'yi', 'й' => 'y', 'к' => 'k',
    'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p',
    'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f',
    'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
    'ь' => '', 'ю' => 'yu', 'я' => 'ya', ' ' => '.'
];
$prefix7 = strtr($lower7, $translit7);
$email7 = $prefix7 . "@example.com";
echo $email7 . "\n";

//завдання 8
$year8 = 2000;
if ($year8 % 400 === 0) {
    echo $year8 . " кратний 400.\n";
} else {
    echo $year8 . " не кратний 400.\n";
}

//завдання 9
$arr9 = [];
for ($i = 0; $i < 10; $i++) {
    $arr9[] = rand(0, 100);
}
echo "Масив: " . implode(", ", $arr9) . "\n";
$product9 = 1;
$hasPositive9 = false;
$positiveElements9 = [];
foreach ($arr9 as $index9 => $value9) {
    if ($value9 > 0) {
        if ($index9 % 2 === 0) {
            $product9 *= $value9;
            $hasPositive9 = true;
        } else {
            $positiveElements9[] = $value9;
        }
    }
}
if ($hasPositive9) {
    echo "Добуток: " . $product9 . "\n";
} else {
    echo "Додатних елементів з парними індексами немає.\n";
}
echo "Додатні елементи з непарними індексами: " . implode(", ", $positiveElements9) . "\n";

//завдання 10
$year10 = 2026;
if ($year10 >= 1 && $year10 <= 9999) {
    if (($year10 % 4 === 0 && $year10 % 100 !== 0) || ($year10 % 400 === 0)) {
        echo $year10 . " високосний.\n";
    } else {
        echo $year10 . " не високосний.\n";
    }
} else {
    echo "Помилка";
}
