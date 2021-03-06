<?php include "../../templates/header.php";
require "../config.php"; ?>
    <div style="text-align: center;">
        <h1 >Mailchimp & Google Analytics Integration - Report Generation App</h1>
        <button  onclick="window.location.href='../../index.php'">Home Page</button>
    </div>
    <div class="container">
        <div class="camp_details_form">
            <h3> Delete Campaign Details</h3>
            <label><strong>Year :</strong></label>
            <select id="yearChange">
                <option selected="selected">--Select Year--</option>
                <?php
                $con = new PDO($dsn, $username, $password, $options);
                $stmt = $con->prepare("SELECT mc.`Months`, mc.`Years`, mc.`Promo Name` 
                    FROM (SELECT `Months`, `Years`, `Promo Name` FROM mc_ga WHERE `Promo Name` NOT LIKE '%Reminder%' GROUP BY `Months`, `Years`, `Promo Name`) mc 
                    LEFT JOIN campaign_details cd ON cd.`Years` = mc.`Years` AND cd.`Months` = mc.`Months` AND cd.`Promo Name` = mc.`Promo Name`
                    WHERE cd.`Years` IS NOT NULL
                    AND cd.`Months` IS NOT NULL
                    AND cd.`Promo Name` IS NOT NULL
                    GROUP BY mc.`Years`");
                $stmt->execute();
                $result = $stmt->fetchAll();
                if ($result && $stmt->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo '<option name="' . ['Years'] . '">' . $row['Years'] . '</option>';
                    }
                } ?>
            </select><br><br>
            <div id="select_month" style="display:none;">
                <label><strong>Month :</strong></label>
                <select id="monthChange"></select><br><br>
            </div>
            <div id="select_promo" style="display:none;">
                <label><strong>Promo Name :</strong></label>
                <select id="promoNameChange"></select><br><br>
            </div>
            <div id="submit_details" style="display:none;">
                <p><strong>Current Campaign Details: </strong></p>
                <div id="current_camp_details"></div><br><br>
                <input id="delete_details_submit" type="submit" value="Delete"/>
            </div>
            <p id="success_message" style="display:none; color: red"><strong>Campaign details has been deleted successfully!</strong></p>
        </div>
        <div id="camp_details_result">
            <?php include "editCampaignDetailsAjax.php" ?>
        </div>
    </div>
<?php include "../../templates/footer.php"; ?>