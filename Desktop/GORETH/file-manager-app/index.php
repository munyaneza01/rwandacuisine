<?php include ('./conn/conn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management System</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/style.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>
</head>
<body>

    <!-- Add File Modal -->
    <div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFile" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFile">Add file</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/add-file.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="fileTitle">File Title</label>
                            <input type="text" class="form-control" id="fileTitle" name="fileTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                        </div>
                        <div class="form-group">
                            <label for="fileUploader">Uploaded By (Optional)</label>
                            <input type="text" class="form-control" id="fileUploader" name="fileUploader">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark">Add File</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update File Modal -->
    <div class="modal fade" id="updateFileModal" tabindex="-1" aria-labelledby="updateFile" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateFile"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/update-file.php" method="POST" enctype="multipart/form-data">
                        <input type="text" class="form-control" id="updateFileID" name="fileID" hidden>
                        <div class="form-group">
                            <label for="fileTitle">File Title</label>
                            <input type="text" class="form-control" id="updateFileTitle" name="fileTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control-file" id="updateFile" name="file" required>
                        </div>
                        <div class="form-group">
                            <label for="updateFileUploader">Uploaded By (Optional)</label>
                            <input type="text" class="form-control" id="updateFileUploader" name="fileUploader">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main">
        <div class="alert alert-dark text-center" role="alert">
            <img src="mipc.jpg" align="left" style="Width:60px; height:60px"/><h2>File Management System</h2> <img src="mipc.jpg" align="right" style="Width:60px; height:60px"/>
        </div>
        <div class="file-container">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#addFileModal" style="width: 120px">
            <i class="fa-solid fa-plus"></i> Add File
            </button>

            <table class="table table-hover text-center" id="fileTable">
                <thead>
                    <tr>
                        <th scope="col">File ID</th>
                        <th scope="col">File Title</th>
                        <th scope="col">File</th>
                        <th scope="col">Uploaded By</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                        $stmt = $conn->prepare("SELECT * FROM `tbl_file`");
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        foreach ($result as $row) {
                            $fileID = $row['tbl_file_id'];
                            $fileTitle = $row['file_title'];
                            $file = $row['file'];
                            $fileUploader = $row['file_uploader'];
                            $dateUploaded = $row['date_uploaded'];


                        ?>
                        <tr class="fileList">
                            <th id="fileID-<?= $fileID ?>"><?php echo $fileID ?></th>
                            <td id="fileTitle-<?= $fileID ?>"><?php echo $fileTitle ?></td>
                            <td id="file-<?= $fileID ?>"><?php echo $file ?></td>
                            <td id="fileUploader-<?= $fileID ?>"><?php echo $fileUploader ?></td>
                            <td id="dateUploaded-<?= $fileID ?>"><?php echo $dateUploaded ?></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-sm text-center">
                                        <button type="button" class="btn btn-success"><i class="fa-solid fa-download" onclick="downloadFile(<?php echo $fileID ?>)" title="Download"></i></button>
                                        <button type="button" class="btn btn-secondary"><i class="fa-solid fa-pencil" onclick="updateFile(<?php echo $fileID ?>)" title="Update"></i></button>
                                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash" onclick="deleteFile(<?php echo $fileID ?>, )" title="Delete"></i></button>
                                    </div>
                                </div>
                                </select>
                            </td>
                        </tr>
                        <?php 
                        }
                    ?>
                </tbody>
            </table>
        </div>
		<div>
		<center><h4> Designed by MUREKEYINKA Goreth</h4></center>
		</div>

    </div>
    


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Script JS -->
    <script src="./assets/script.js"></script>

    <!-- Data Tables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


</body>
</html>