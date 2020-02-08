     <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Специальность</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="spec">
                            <option selected>Выбрать...</option>
                            <option value="1">Терапевт</option>
                            <option value="2">Ортопед</option>
                            <option value="3">Ортодонт</option>
                            <option value="4">Пародонтолог</option>
                            <option value="5">Хирург</option>
                            <option value="6">Зубной техник</option>
                        </select>
                    </div>




        $query="INSERT INTO `врач`(`специальность`,`фамилия`,`имя`,`отчество`)VALUES(?,?,?,?)";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("ssss",$spec,$name,$surname,$lastname);
        $stmt->execute();


                $result = mysqli_query($conn,"SELECT кодСпец FROM специальность where название ='".$spec."'");
        $row = mysqli_fetch_array($result);
        $res = $row['кодСпец'];