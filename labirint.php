
<form method="post" action="labirint.php">
    <input type="text" size="25" placeholder="ведите начальную X от (0-7)" name="x" required>
    <input type="text" size="25" placeholder="ведите начальную Y от (0-7)" name="y" required><br/>
    <input type="text" size="25" placeholder="ведите конечную X от (0-7)" name="X" required>
    <input type="text" size="25" placeholder="ведите конечную X от (0-7)" name="Y" required><br/>
    <input type="submit" name="send" value="start">
</form>

<?php
$aMap = array(
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
);



class Labirint {
    /* старт точки Х */
    public $start_x;
    /* старт точки Y */
    public $start_y;
    /* карта заданая юзером */
    public $Map;
    /* карта созданная классом */
    public $aMap;

    /* дистанция точки X */
    public $destination_x;

    /*дистанция точки Y */
    public $destination_y;

    /* поиск дороги */
    public $Way = array();

    /* конец дороги */
    public $aWays = array();

    /* число поиска следуешего шага */
    public $fillNumber = 0;

    public function __construct($x, $y, $Map) {
        $this->Map = $Map;

        $this->aWays[] = array($x, $y);
        $this->start_x = $x;
        $this->start_y = $y;

        $this->Mapgenerate();
    }

    /*начало поиска пути*/
    public function startWay($x, $y, $withSide = true) {
        $this->destination_x = $x;
        $this->destination_y = $y;

        $this->startFinding();
        $this->Way[] = array($y, $x);
        $this->reverseSearch($x, $y);
        if ($withSide) {
            $ways = $this->Way;
            foreach ($ways AS $i => $v) {
                if (isset($ways[$i + 1]) AND $this->checkSidelong($v[1], $v[0], $ways[$i + 1][1], $ways[$i + 1][0])) {
                    $this->researchWay($ways, $i);
                }
            }
        }
        return array_reverse($this->Way);
    }

    /*проверка стороны пути */
    private function checkSidelong($x, $y, $x1, $y1) {
        if (abs($x1 - $x) == 1 AND abs($y1 - $y) == 1) {
            return true;
        }
    }

   /*проверка пути*/
    private function researchWay($ways, $ii) {
        list($y, $x) = $ways[$ii];
        $new_x[] = $x + 1;
        $new_y[] = $y;

        $new_x[] = $x + 1;
        $new_y[] = $y + 1;

        $new_x[] = $x + 1;
        $new_y[] = $y - 1;

        $new_x[] = $x - 1;
        $new_y[] = $y;

        $new_x[] = $x - 1;
        $new_y[] = $y + 1;

        $new_x[] = $x - 1;
        $new_y[] = $y - 1;

        $new_x[] = $x;
        $new_y[] = $y + 1;

        $new_x[] = $x;
        $new_y[] = $y - 1;

        foreach ($new_x AS $i => $v) {
            list($nextY, $nextX) = $ways[$ii + 1];
            if (isset($this->aMap[$new_y[$i]][$v]) && $this->aMap[$new_y[$i]][$v] > 0 && !($new_y[$i] == $nextY && $v == $nextX) && ($this->aMap[$new_y[$i]][$v] == $this->aMap[$y][$x] || $this->aMap[$new_y[$i]][$v] == ($this->aMap[$y][$x] - 1)) && (abs($v - $nextX) == 1 || abs($v - $nextX) == 0) && (abs($new_y[$i] - $nextY) == 1 || abs($new_y[$i] - $nextY) == 0)) {
                $this->fillArray(array($y, $x), array($new_y[$i], $v));
                break;
            }
        }
    }

   /*поиск обратной стороны */
    private function reverseSearch($x, $y) {
        $new_x[] = $x + 1;
        $new_y[] = $y;

        $new_x[] = $x + 1;
        $new_y[] = $y + 1;

        $new_x[] = $x + 1;
        $new_y[] = $y - 1;

        $new_x[] = $x - 1;
        $new_y[] = $y;

        $new_x[] = $x - 1;
        $new_y[] = $y + 1;

        $new_x[] = $x - 1;
        $new_y[] = $y - 1;

        $new_x[] = $x;
        $new_y[] = $y + 1;

        $new_x[] = $x;
        $new_y[] = $y - 1;
        foreach ($new_x AS $i => $v) {
            if (isset($this->aMap[$new_y[$i]][$v]) AND $this->aMap[$new_y[$i]][$v] == ($this->aMap[$y][$x] - 1)) {
                $this->Way[] = array($new_y[$i], $v);
                $this->reverseSearch($v, $new_y[$i]);
                break;
            }
        }
    }

    /*начать поиск */
    private function startFinding() {
        foreach ($this->aWays AS $v) {
            list($x, $y) = $v;
            $this->aMap[$y][$x] = $this->fillNumber;
            $new_x[] = $x + 1;
            $new_y[] = $y;

            $new_x[] = $x + 1;
            $new_y[] = $y + 1;

            $new_x[] = $x + 1;
            $new_y[] = $y - 1;

            $new_x[] = $x - 1;
            $new_y[] = $y;

            $new_x[] = $x - 1;
            $new_y[] = $y + 1;

            $new_x[] = $x - 1;
            $new_y[] = $y - 1;

            $new_x[] = $x;
            $new_y[] = $y + 1;

            $new_x[] = $x;
            $new_y[] = $y - 1;
            $paths = array();
            foreach ($new_x AS $i => $v) {
                if (isset($this->aMap[$new_y[$i]][$v]) AND $this->aMap[$new_y[$i]][$v] == -1) {
                    if ($v == $this->destination_x AND $new_y[$i] == $this->destination_y) {
                        $paths[] = array($v, $new_y[$i]);
                        break;
                    }
                    $paths[] = array($v, $new_y[$i]);
                }
            }
        }

        $this->fillNumber++;
        if (isset($paths)) {
            $this->aWays = $paths;
            $this->startFinding();
        }
    }

   /*генерация карты пути*/
    private function Mapgenerate() {
        foreach ($this->Map AS $y => $v_) {
            foreach ($v_ AS $x => $v) {
                if ($v == 1) {
                    $this->aMap[$y][$x] = -2;
                } elseif ($v == 0) {
                    $this->aMap[$y][$x] = -1;
                } else {
                    $this->aMap[$y][$x] = -2;
                }
            }
        }
    }

   /*заполнение масива данными*/
    private function fillArray($punkt_vpered, $nowy_punkt) {
        $vpered = array_search($punkt_vpered, $this->Way);
        $a = array_slice($this->Way, 0, $vpered + 1);
        $b = array_slice($this->Way, $vpered + 1);
        $a[] = $nowy_punkt;
        $this->Way = array_merge($a, $b);
    }

}

$x=$_POST['x'];
$y=$_POST['y'];
$X=$_POST['X'];
$Y=$_POST['Y'];
$start=isset($_POST['send']);
$Way = new Labirint($X, $Y, $aMap);

if($start==TRUE){
    $way = $Way->startWay($x, $y);
    echo '<pre>';
    var_dump($way);
    echo '</pre>';
}
