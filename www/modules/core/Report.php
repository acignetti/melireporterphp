<?php
namespace Reporter\modules\core;

class Report extends \Reporter\modules\database\Connector {

    private static $_header = array();
    private static $_graphs = array();
    private static $_footer = array();
    private static $_tables = '';

    private static function recoverCategories($dataObjects) {
        $resultSet = array();

        foreach ($dataObjects as $object) {
            if (array_search($object->category_name, $resultSet) === false) {
                $resultSet[$object->category_name] = $object->category_name;
            }
        }

        return $resultSet;
    }

    private static function recoverBuyers($dataObjects) {
        $resultSet = array();

        foreach ($dataObjects as $object) {
            if (array_search($object->buyer_id, $resultSet) === false) {
                $resultSet[] = $object->buyer_id;
            }
        }

        return $resultSet;
    }

    private static function recoverDates($dataObjects) {
        $resultSet = array();

        foreach ($dataObjects as $object) {
            if (array_search($object->sale_bought_on, $resultSet) === false) {
                $resultSet[] = $object->sale_bought_on;
            }
        }

        return $resultSet;
    }

    private static function recoverItems($dataObjects) {
        $resultSet = array();

        foreach ($dataObjects as $object) {
            if (array_search($object->item_id, $resultSet) === false) {
                $resultSet[] = $object->item_id;
            }
        }

        return $resultSet;
    }

    private static function createColumnChart($username, $saleIDs) {
        $query = "SELECT
            ca.category_name,
            SUM(sa.sale_quantity) as total
        FROM sales sa
        INNER JOIN items it ON sa.sale_item_id = it.item_id
        INNER JOIN buyers bu ON sa.sale_buyer_id = bu.buyer_id
        INNER JOIN categories ca ON it.item_category_id = ca.category_id
        INNER JOIN users us ON sa.sale_user_id = us.user_id
        WHERE sa.sale_id in (" . implode(',', $saleIDs) . ")
        AND us.user_name = '{$username}'
        group by ca.category_name";

        $resultSet  = self::_execute($query);

        $inlineJs  = 'function drawChartColumn() { var data = google.visualization.arrayToDataTable([';
        $inlineJs .= '[\'Category\', \'Total sales\']';

        foreach ($resultSet as $aCategory) {
            $inlineJs .= ',[\''.$aCategory->category_name.'\', ' . $aCategory->total .']';
        }

        $inlineJs .= ']);var options = { "is3D" : false }; var chart = new google.visualization.ColumnChart(document.getElementById(\'column_chart\')); chart.draw(data, options); }';

        self::$_header[] = 'google.setOnLoadCallback(drawChartColumn);';
        self::$_graphs[] = $inlineJs;
        self::$_footer[] = 'drawChartColumn();';
    }

    private static function createPieGraph($username, $saleIDs) {
        $query = "SELECT
            ca.category_name,
            SUM(sa.sale_quantity) as total
        FROM sales sa
        INNER JOIN items it ON sa.sale_item_id = it.item_id
        INNER JOIN buyers bu ON sa.sale_buyer_id = bu.buyer_id
        INNER JOIN categories ca ON it.item_category_id = ca.category_id
        INNER JOIN users us ON sa.sale_user_id = us.user_id
        WHERE sa.sale_id in (" . implode(',', $saleIDs) . ")
        AND us.user_name = '{$username}'
        group by ca.category_name";

        $resultSet  = self::_execute($query);

        $inlineJs  = 'function drawChartPie() { var data = google.visualization.arrayToDataTable([';
        $inlineJs .= '[\'Category\', \'Total sales\']';

        foreach ($resultSet as $aCategory) {
            $inlineJs .= ',[\''.$aCategory->category_name.'\', ' . $aCategory->total .']';
        }

        $inlineJs .= ']);var options = { is3D: true }; var chart = new google.visualization.PieChart(document.getElementById(\'piechart_3d\')); chart.draw(data, options); }';

        self::$_header[] = 'google.setOnLoadCallback(drawChartPie);';
        self::$_graphs[] = $inlineJs;
        self::$_footer[] = 'drawChartPie();';
    }

    private static function createLineGraph($username, $saleIDs) {
        $query = "SELECT
            ca.category_name,
            date(sa.sale_bought_on),
            SUM(sa.sale_quantity) as total
        FROM sales sa
        INNER JOIN items it ON sa.sale_item_id = it.item_id
        INNER JOIN buyers bu ON sa.sale_buyer_id = bu.buyer_id
        INNER JOIN categories ca ON it.item_category_id = ca.category_id
        INNER JOIN users us ON sa.sale_user_id = us.user_id
        WHERE sa.sale_id in (" . implode(',', $saleIDs) . ")
        AND us.user_name = '{$username}'
        group by ca.category_name";

        $resultSet  = self::_execute($query);

        $inlineJs  = 'function drawChartLine() { var data = google.visualization.arrayToDataTable([';
        $inlineJs .= '[\'Category\', \'Total sales\']';

        foreach ($resultSet as $aCategory) {
            $inlineJs .= ',[\''.$aCategory->category_name.'\', ' . $aCategory->total .']';
        }

        $inlineJs .= ']);var options = { title: \'Items Performance\' }; var chart = new google.visualization.LineChart(document.getElementById(\'chart_div\')); chart.draw(data, options); }';

        self::$_header[] = 'google.setOnLoadCallback(drawChartLine);';
        self::$_graphs[] = $inlineJs;
        self::$_footer[] = 'drawChartLine();';
    }

    private static function createStackedGraph($username, $saleIDs) {
        $query = "SELECT
            bu.buyer_id,
            ca.category_name,
            '1' as toSum
        FROM sales sa
        INNER JOIN items it ON sa.sale_item_id = it.item_id
        INNER JOIN buyers bu ON sa.sale_buyer_id = bu.buyer_id
        INNER JOIN categories ca ON it.item_category_id = ca.category_id
        INNER JOIN users us ON sa.sale_user_id = us.user_id
        WHERE sa.sale_id in (" . implode(',', $saleIDs) . ")
        AND us.user_name = '{$username}'";

        $resultSet  = self::_execute($query);
        $categories = self::recoverCategories($resultSet);

        $inlineJs  = 'function drawChartStacked() { var data = google.visualization.arrayToDataTable([';
        $inlineJs .= '[\'Category\', \'' . implode("','", $categories) . '\']';

        $userSet = self::recoverBuyers($resultSet);

        foreach ($userSet as $user) {
            $queryUser = "SELECT
                bu.buyer_id,
                bu.buyer_name,
                ca.category_name,
                count(bu.buyer_id) as total
            FROM sales sa
            INNER JOIN items it ON sa.sale_item_id = it.item_id
            INNER JOIN buyers bu ON sa.sale_buyer_id = bu.buyer_id
            INNER JOIN categories ca ON it.item_category_id = ca.category_id
            INNER JOIN users us ON sa.sale_user_id = us.user_id
            WHERE sa.sale_id in (" . implode(',', $saleIDs) . ")
            AND bu.buyer_id = '{$user}'
            group by ca.category_name";

            $resultSet2 = self::_execute($queryUser);
            $tmpArr = array();
            $tmpArr[] = $resultSet2[0]->buyer_name;

            foreach ($resultSet2 as $resultToProc) {
                $tmpArr[$categories[$resultToProc->category_name]] = $resultToProc->total;
            }

            $inlineJs .= ',[\''.array_shift($tmpArr).'\', '.implode(" ,", $tmpArr).']';
        }

        $inlineJs .= ']);var options = { isStacked: true }; var chart = new google.visualization.ColumnChart(document.getElementById(\'column_chart_stacked\')); chart.draw(data, options); }';

        self::$_header[] = 'google.setOnLoadCallback(drawChartStacked);';
        self::$_graphs[] = $inlineJs;
        self::$_footer[] = 'drawChartStacked();';
    }

    private static function createDataTable($username, $saleIDs) {
        $query = "SELECT
            date(it.item_published_on) as d1,
            date(sa.sale_bought_on) as d2,
            sa.sale_quantity as d3,
            it.item_name as d4,
            sa.sale_status as d5,
            sa.sale_total as d6
        FROM sales sa
        INNER JOIN items it ON sa.sale_item_id = it.item_id
        INNER JOIN buyers bu ON sa.sale_buyer_id = bu.buyer_id
        INNER JOIN categories ca ON it.item_category_id = ca.category_id
        INNER JOIN users us ON sa.sale_user_id = us.user_id
        WHERE sa.sale_id in (" . implode(',', $saleIDs) . ")
        AND us.user_name = '{$username}'";

        $resultSet  = self::_execute($query);

        foreach ($resultSet as $aSale) {
            self::$_tables .= "
                <tr>
                    <td>{$aSale->d1}</td>
                    <td>{$aSale->d2}</td>
                    <td>{$aSale->d3}</td>
                    <td>{$aSale->d4}</td>
                    <td>{$aSale->d5}</td>
                    <td>{$aSale->d6}</td>
                </tr>";
        }
    }

    public static function createReport($type, $username, $saleIDs) {

        header_remove();

        if ($type == 'pdf') {
            header('Content-type: application/pdf');
            exec(__DIR__ . '/test.php');
            exec('wkhtmltopdf '.__MAIN__ . 'template/report.html' .__MAIN__ . 'template/tmp.pdf 2>&1');
            $processedFile = file_get_contents(__MAIN__ . 'template/tmp.pdf');
        } else {
            header('Content-type: text/html');

            self::createStackedGraph($username, $saleIDs);
            self::createColumnChart($username, $saleIDs);
            self::createLineGraph($username, $saleIDs);
            self::createPieGraph($username, $saleIDs);
            self::createDataTable($username, $saleIDs);

            $processedFile = file_get_contents(__MAIN__ . 'template/report.html');
            $processedFile = str_replace('##header##', implode(' ', self::$_header), $processedFile);
            $processedFile = str_replace('##graphs##', implode(' ', self::$_graphs), $processedFile);
            $processedFile = str_replace('##footer##', implode(' ', self::$_footer), $processedFile);
            $processedFile = str_replace('##tables##', self::$_tables, $processedFile);

        }

        /**
         * Echo the file and cut the execution because Slim adds a new header
         */
        echo $processedFile; exit;
    }

}
