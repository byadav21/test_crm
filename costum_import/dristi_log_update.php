<table class="table table-bordered">
    <thead>
        <tr>
            <th>Lead ID</th>
            <th>dispositionName</th>
            <th>callType</th>
            <th>dristi_customer_id</th>
        </tr>	
    </thead>
    <?php
    include 'db.php';


    $SQLSELECT  = " SELECT id,dristi_customer_id
                            FROM `leads`
                    WHERE dispositionName IS NULL
                      AND callType IS NULL 
                      AND dristi_customer_id IS NOT NULL
                    LIMIT 300000000  ";
    $result_set = mysqli_query($conn, $SQLSELECT) or die('error:' . mysqli_error($conn));


    while ($emapData = mysqli_fetch_assoc($result_set))
    {
        $SQLSELECTx  = "SELECT  
                                    dl.lead_id,
                                    dl.`dispositionName`,
                                    dl.dated,
                                    dl.`entryPoint`,
                                    dl.`callType`
                            FROM `dristi_log` dl
                            WHERE dl.customer_id='" . $emapData['dristi_customer_id'] . "'
                              AND dl.`entryPoint`='dispose amyo'
                        ORDER BY  dl.dated DESC
                        LIMIT 1";
        $result_setx = mysqli_query($conn, $SQLSELECTx) or die("error 1:" . mysqli_errno());
        $contRow     = mysqli_num_rows($result_setx);
        $data        = mysqli_fetch_assoc($result_setx);



        if ($contRow > 0)
        {
            $Leadssql = "update  "
                    . "  leads set "
                    . "  dispositionName='" . $data['dispositionName'] . "',"
                    . "  callType='" . $data['callType'] . "' "
                    . "  where id ='" . $data['lead_id'] . "'";
            $result   = mysqli_query($conn, $Leadssql);
            ?>

            <tr>
                <td><?php echo $data['lead_id']; ?></td>
                <td><?php echo $data['dispositionName']; ?></td>
                <td><?php echo $data['callType']; ?></td>
                <td><?php echo $emapData['dristi_customer_id']; ?></td>

            </tr>
            <?php
        }
    }


//close of connection
    mysqli_close($conn);
    ?>	
</table>