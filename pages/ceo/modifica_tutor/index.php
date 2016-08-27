<?php
    include '../../functions.php';
    checkLogin ( ceoType , "../../../");
    import("../../../");
    open_html ( "Modifica Tutor" );
    $id_az = $_SESSION ['userId'];
?>
<body>
    
    <style>
.minw{
    width: 65%;
}
    </style>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <script src="scripts/scripts.js"> </script>
    
    <!-- Begin Body -->
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="panel" id="mainPanel" style="min-height: 0px">
					<h1>Visualizza Tutor</h1> 
                                        
                                        <?php
                                            $conn = dbConnection("../../../");
                                            $query = "SELECT * FROM tutor WHERE azienda_id_azienda = ".$_SESSION['userId']." ORDER BY cognome ASC";
                                            $result = $conn->query($query);
                                            echo "<div class = \"row\"> <div class = \"col col-sm-12\">";
                                            $I=0;
                                            if($result->num_rows > 0)
                                            {
                                                echo "<br><div class=\"table-responsive\"><table class=\"table table-bordered\"> <tbody>";
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<tr><td class=\"minw\">";
                                                    echo "<div id=\"VisibleBox$I\">";
                                                        echo "<label id=\"label".$I."\"> ".$row['cognome']." ".$row['nome']." (".$row['username'].")</label> <input class=\"btn \" type=\"button\" value=\"modifica\" style=\"visibility:hidden\">";
                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                        echo "<div id=\"ButtonBox$I\" align=\"center\"><input class=\"btn btn-success\" type=\"button\" id=\"modifica$I\" value=\"Modifica\" onclick=\"openEdit('$I','".$row['id_tutor']."')\"> <input class=\"btn btn-danger\" type=\"button\" value=\"Elimina\" onclick = \"deleteTutor(".$row['id_tutor'].")\"> <br></div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $I++;
                                                }
                                                echo "</tbody></table></div>";
                                            }
                                            echo "</div>";
                                            echo "</div>";
                                        ?>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
    close_html ();
?>