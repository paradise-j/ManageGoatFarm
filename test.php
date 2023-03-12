<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="inputState" class="form-label">ประเภทลี้ยง</label>
                                    <br><br>
                                    <label id="myLabel">ประเภท....</label>
                                    <br><br>
                                    <select class="form-control" aria-label="Default select example" id="myinput" style="border-radius: 30px;" required>
                                        <option selected>กรุณาเลือก....</option>
                                        <option value="แบบยืนโรง">แบบยืนโรง</option>
                                        <option value="แบบกึ่ง">แบบกึ่ง</option>
                                        <option value="แบบธรรมชาติ">แบบธรรมชาติ</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <br><br>
                                    <a href="test.php?value=แบบยืนโรง" data-id="แบบยืนโรง" type="submit" class="select-btn" id="myinput">บันทึกข้อมูล</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        // function fetchData() {
        //     var inputVal = document.getElementById("myinput").value;
        //     document.getElementById("myLabel").innerHTML = inputVal;
        // }

        $(".select-btn").click(function(e) {
            var inputVal = document.getElementById("myinput").value;
            document.getElementById("myLabel").innerHTML = inputVal;
        })
    </script>
</html>