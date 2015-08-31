
<form method="post" action="labirint.php">
    <input type="text" size="25" placeholder="ведите начальную X от (0-7)" name="x" required>
    <input type="text" size="25" placeholder="ведите начальную Y от (0-7)" name="y" required><br/>
    <input type="text" size="25" placeholder="ведите конечную X от (0-7)" name="X" required>
    <input type="text" size="25" placeholder="ведите конечную X от (0-7)" name="Y" required><br/>

    <p style="margin-left: 70px;">вы можете поставить барьеры на карте</p>
    <div style="margin-left: 100px;">
        <input type="checkbox" name="ch1" value="1"  >
        <input type="checkbox" name="ch2" value="1"  >
        <input type="checkbox" name="ch3" value="1"  >
        <input type="checkbox" name="ch4" value="1"  >
        <input type="checkbox" name="ch5" value="1"  >
        <input type="checkbox" name="ch6" value="1"  >
        <input type="checkbox" name="ch7" value="1"  >
        <input type="checkbox" name="ch8" value="1"  >
        <br>
        <input type="checkbox" name="ch9" value="1"  >
        <input type="checkbox" name="ch10" value="1"  >
        <input type="checkbox" name="ch11" value="1"  >
        <input type="checkbox" name="ch12" value="1"  >
        <input type="checkbox" name="ch13" value="1"  >
        <input type="checkbox" name="ch14" value="1"  >
        <input type="checkbox" name="ch15" value="1"  >
        <input type="checkbox" name="ch16" value="1"  >
        <br>
        <input type="checkbox" name="ch17" value="1"  >
        <input type="checkbox" name="ch18" value="1"  >
        <input type="checkbox" name="ch19" value="1"  >
        <input type="checkbox" name="ch20" value="1"  >
        <input type="checkbox" name="ch21" value="1"  >
        <input type="checkbox" name="ch22" value="1"  >
        <input type="checkbox" name="ch23" value="1"  >
        <input type="checkbox" name="ch24" value="1"  ><br/>

        <input type="checkbox" name="ch25" value="1"  >
        <input type="checkbox" name="ch26" value="1"  >
        <input type="checkbox" name="ch27" value="1"  >
        <input type="checkbox" name="ch28" value="1"  >
        <input type="checkbox" name="ch29" value="1"  >
        <input type="checkbox" name="ch30" value="1"  >
        <input type="checkbox" name="ch31" value="1"  >
        <input type="checkbox" name="ch32" value="1"  ><br/>


        <input type="checkbox" name="ch33" value="1"  >
        <input type="checkbox" name="ch34" value="1"  >
        <input type="checkbox" name="ch35" value="1"  >
        <input type="checkbox" name="ch36" value="1"  >
        <input type="checkbox" name="ch37" value="1"  >
        <input type="checkbox" name="ch38" value="1"  >
        <input type="checkbox" name="ch39" value="1"  >
        <input type="checkbox" name="ch40" value="1"  ><br/>

        <input type="checkbox" name="ch41" value="1"  >
        <input type="checkbox" name="ch42" value="1"  >
        <input type="checkbox" name="ch43" value="1"  >
        <input type="checkbox" name="ch44" value="1"  >
        <input type="checkbox" name="ch45" value="1"  >
        <input type="checkbox" name="ch46" value="1"  >
        <input type="checkbox" name="ch47" value="1"  >
        <input type="checkbox" name="ch48" value="1"  ><br/>

        <input type="checkbox" name="ch49" value="1"  >
        <input type="checkbox" name="ch50" value="1"  >
        <input type="checkbox" name="ch51" value="1"  >
        <input type="checkbox" name="ch52" value="1"  >
        <input type="checkbox" name="ch53" value="1"  >
        <input type="checkbox" name="ch54" value="1"  >
        <input type="checkbox" name="ch55" value="1"  >
        <input type="checkbox" name="ch56" value="1"  ><br/>

        <input type="checkbox" name="ch57" value="1"  >
        <input type="checkbox" name="ch58" value="1"  >
        <input type="checkbox" name="ch59" value="1"  >
        <input type="checkbox" name="ch60" value="1"  >
        <input type="checkbox" name="ch61" value="1"  >
        <input type="checkbox" name="ch62" value="1"  >
        <input type="checkbox" name="ch63" value="1"  >
        <input type="checkbox" name="ch64" value="1"  ><br/><br/>
    </div>
    <input style="margin-left: 170px;" type="submit" name="send" value="start">
</form>


<?php

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

            $new_x[] = $x - 1;
            $new_y[] = $y;

            $new_x[] = $x;
            $new_y[] = $y + 1;

            $new_x[] = $x;
            $new_y[] = $y - 1;

            $new_x[] = $x + 1;
            $new_y[] = $y + 1;

            $new_x[] = $x + 1;
            $new_y[] = $y - 1;

            $new_x[] = $x - 1;
            $new_y[] = $y + 1;

            $new_x[] = $x - 1;
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
    /*создание визуальной карты пути*/
    public function visualMap() {
        echo '<style>
            .map_wall {
                width: 40px;
                height: 40px;
                background: #662666;
                color: white;
                font-weight: bold;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .way {
                width: 40px;
                height: 40px;
                background: #6e17ea;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .finish {
                width: 40px;
                height: 40px;
                background: #218006;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .wall {
                width: 40px;
                height: 40px;
                background: #ff1d0f;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .map {
                width: 40px;
                height: 40px;
                background: #fff;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
        ';
        foreach ($this->Way AS $v) {
            list($y, $x) = $v;
            echo '.x' . $x . 'y' . $y . ' { background: #9AD9EA !important; }';
        }
        echo '</style>';
        echo '<div style="clear: both;"> </div>';
        for ($i = 0; $i < 9; $i++) {
            echo '<div class="map_wall">' . $i . '</div>';
        }
        echo '<div style="clear: both;"> </div>';
        foreach ($this->aMap AS $y => $v_) {
            echo '<div class="map_wall">' . ($y + 1) . '</div>';
            foreach ($v_ AS $x => $v) {
                if ($v > 0) {
                    echo '<div class="map x' . $x . 'y' . $y . '"></div>';
                } elseif ($v == 0) {
                    echo '<div class="finish"></div>';
                } elseif ($v == -2) {
                    echo '<div class="wall"></div>';
                } elseif ($v == -1) {
                    echo '<div class="map"></div>';
                }elseif($v==1){
                    echo 'start';
                }
            }
            echo '<div style="clear: both;"> </div>';
        }
    }


}

$start=isset($_POST['send']);
if($start==TRUE){
    $ch1=$_POST['ch1'];$ch2=$_POST['ch2'];$ch3=$_POST['ch3'];$ch4=$_POST['ch4'];$ch5=$_POST['ch5'];$ch6=$_POST['ch6'];$ch7=$_POST['ch7'];$ch8=$_POST['ch8'];$ch9=$_POST['ch9'];$ch10=$_POST['ch10'];$ch11=$_POST['ch11'];$ch12=$_POST['ch12'];$ch13=$_POST['ch13'];$ch14=$_POST['ch14'];$ch15=$_POST['ch15'];$ch16=$_POST['ch16'];$ch17=$_POST['ch17'];$ch18=$_POST['ch18'];$ch19=$_POST['ch19'];$ch20=$_POST['ch20'];$ch21=$_POST['ch21'];$ch22=$_POST['ch22'];$ch23=$_POST['ch23'];$ch24=$_POST['ch24'];$ch25=$_POST['ch25'];$ch26=$_POST['ch26'];$ch27=$_POST['ch27'];$ch28=$_POST['ch28'];$ch29=$_POST['ch29'];$ch30=$_POST['ch30'];$ch31=$_POST['ch31'];$ch32=$_POST['ch32'];$ch33=$_POST['ch33'];$ch34=$_POST['ch34'];$ch35=$_POST['ch35'];$ch36=$_POST['ch36'];$ch37=$_POST['ch37'];$ch38=$_POST['ch38'];$ch39=$_POST['ch39'];$ch40=$_POST['ch40'];
    $ch41=$_POST['ch41'];$ch42=$_POST['ch42'];$ch43=$_POST['ch43'];$ch44=$_POST['ch44'];$ch45=$_POST['ch45'];$ch46=$_POST['ch46'];$ch47=$_POST['ch47'];$ch48=$_POST['ch48'];$ch49=$_POST['ch49'];$ch50=$_POST['ch50'];$ch51=$_POST['ch51'];$ch52=$_POST['ch52'];$ch53=$_POST['ch53'];$ch54=$_POST['ch54'];$ch55=$_POST['ch55'];$ch56=$_POST['ch56'];
    $ch57=$_POST['ch57']; $ch58=$_POST['ch58'];$ch59=$_POST['ch59'];$ch60=$_POST['ch60'];$ch61=$_POST['ch61'];$ch62=$_POST['ch62'];$ch63=$_POST['ch63'];$ch64=$_POST['ch64'];

    for($ch=1;$ch<65;$ch++){if(empty($ch)){$ch1=0;}}

    $aMap = array(
        array($ch1,$ch2,$ch3,$ch4,$ch5,$ch6,$ch7,$ch8),
        array($ch9,$ch10,$ch11,$ch12,$ch13,$ch14,$ch15,$ch16),
        array($ch17,$ch18,$ch19,$ch20,$ch21,$ch22,$ch23,$ch24),
        array($ch25,$ch26,$ch27,$ch28,$ch29,$ch30,$ch31,$ch32),
        array($ch33,$ch34,$ch35,$ch36,$ch37,$ch38,$ch39,$ch40),
        array($ch41,$ch42,$ch43,$ch44,$ch45,$ch46,$ch47,$ch48),
        array($ch49,$ch50,$ch51,$ch52,$ch53,$ch54,$ch55,$ch56),
        array($ch57,$ch58,$ch59,$ch60,$ch61,$ch62,$ch63,$ch64),
    );


    $x=$_POST['x'];
    $y=$_POST['y'];
    $X=$_POST['X'];
    $Y=$_POST['Y'];

    $Way = new Labirint($X, $Y, $aMap);
    $way = $Way->startWay($x, $y);
    $Way->visualMap();

    $way=array_reverse($way);
    foreach($way AS $key=>$v){
        echo "<br/>шаг №". ($key+1). "&nbsp;&nbsp;y:".($v[0]+1)."&nbsp;&nbsp;x:".($v[1]+1).";";
    }
    $cnt=count($way);
    echo"<br/><br/>кол-во шагов: &nbsp;".$cnt;
}

