<?php
if (isset($_POST['displaySendDistr'])) {
    // Connexion PDO
    try {
        $con = new PDO("mysql:host=localhost;dbname=jh_db", "root", "");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $table = '<table class="table table-striped">                
                    <thead class="thead-dark">                    
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom bénéneficiaire</th> 
                            <th scope="col">Don</th>
                            <th scope="col">Quantité don</th>
                            <th scope="col">Type don</th>   
                            <th scope="col">Quantité distribuée</th>  
                            <th scope="col">Lieu/Adresse de distribution</th> 
                            <th scope="col">Date distribution</th>             
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>';

        // Requête avec PDO
        $sql = "SELECT * FROM vdistribution";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $numero = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $idDistr = $row['codeDistr'];
            $nomBenef = $row['codeBenef'];
            $Don = $row['designationDon'];
            $Qte = $row['Qte_montant'];
            $Unit = $row['unite'];
            $typeD = $row['codeTypeDon'];
            $Montant = $row['Qte_montant_distr'];
            $Devise = $row['unite_devise'];
            $lieu = $row['lieuDistr'];
            $adr = $row['adresseLieuDistr'];
            $dateDistr = $row['dateDistr'];

            $table .= '
            <tr>
                <td scope="row">' . $idDistr . '</td>
                <td>' . $nomBenef . '</td> 
                <td>' . $Don . '</td> 
                <td>' . $Qte . ' ' . $Unit . '</td> 
                <td>' . $typeD . '</td> 
                <td>' . $Montant . ' ' . $Devise . '</td>   
                <td>' . $lieu . ' /' . $adr . '</td> 
                <td>' . $dateDistr . '</td>                                                      
                <td>
                    <button class="text-primary me-2 btn btn-light" title="Modifier" onclick="voirDistribution(' . $idDistr . ')"><i class="fas fa-edit"></i></button>
                    <button class="text-danger me-2 btn btn-light" onclick="deleteDistribution(' . $idDistr . ')" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
            $numero++;
        }

        $table .= '</table>';
        echo $table;

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
