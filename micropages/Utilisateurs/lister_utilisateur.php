<div class="data-table-area mg-b-15 animated zoomIn">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="text-center"><strong> Liste des Utilisateurs</strong></h1>
                                <?php
                                if (($_SESSION["roleuser"] == "administrateur")) {
                                    ?>
                                   <div class="add-product">
                                         <a href="<?= $url; ?>?page=<?php echo base64_encode('micropages/Utilisateurs/ajouter_utilisateur/ajout_utilisateur'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                                     </div> 
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                               <div id="toolbar">
                                    <select class="form-control dt-tb" >
                                        <option value="">Exporter</option>
                                        <option value="all">Exporter Tout</option>
                                        <option value="selected">Exporter la Selection</option>
                                    </select>
                                </div> 
                                <table id="table" class="table " data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th>photo</th>
                                            <th>nom</th>
                                            <th>prenom</th>
                                            <th>E-mail</th>
                                            <th>Genre</th>
                                            <th>T&eacute;l&eacute;phone</th>
                                            <th>cni</th>
                                            <th>R&ocirc;le</th>
                                            <th>Login</th>
                                            <th>Etat</th>
                                            <th>Date</th>
                                            <th>Op&eacute;ration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        lister_utilisateur($con);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>