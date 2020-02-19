<?php
	include 'config.php';
	$output='';

	if(isset($_POST['query'])){
		$search=$_POST['query'];
		$stmt=$conn->prepare("SELECT
                          booking.id,
                          booking.date,
                          booking.timeslot,
                          врач.специальность,
                          врач.фамилия,
                          врач.имя,
                          врач.отчество,
                          users.фамилия as фамПац
                        FROM booking
                          INNER JOIN врач
                            ON booking.doctor = врач.кодВрача
                          INNER JOIN users
                            ON booking.user = users.id
                            WHERE users.фамилия <> 'ВЫХОДНОЙ' AND врач.фамилия LIKE CONCAT('%',?,'%')
							ORDER BY booking.date DESC");
		$stmt->bind_param("s",$search);
	} else {
		$stmt=$conn->prepare("SELECT
                          booking.id,
                          booking.date,
                          booking.timeslot,
                          врач.специальность,
                          врач.фамилия,
                          врач.имя,
                          врач.отчество,
                          users.фамилия as фамПац
                        FROM booking
                          INNER JOIN врач
                            ON booking.doctor = врач.кодВрача
                          INNER JOIN users
                            ON booking.user = users.id
                            WHERE users.фамилия <> 'ВЫХОДНОЙ'
							ORDER BY booking.date DESC");

	}
	$stmt->execute();
	$result=$stmt->get_result();

	if($result->num_rows>0){
		$output = "<thead>
                        <tr>
                             <th>#</th>
                            <th>Дата</th>
                            <th>Время</th>
            
                            <th>Врач</th>
                            <th>Пациент</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($row=$result->fetch_assoc()){
                    	$output.= "
                    	<tr>
                    	<td>
                    	".$row['id']."
                            </td>
                             
                            <td>
                             ".$row['date']."
                            </td>
                            <td>
                            ".$row['timeslot']."
                            </td>
                            <td>
                         	".$row['фамилия']." ".$row['имя']." ".$row['отчество']."
                            </td>
                            <td>
                             ".$row['фамПац']."
                            </td>
                         
                            <td>
                               
                               
                            </td>
						</tr>";
                    }
                    $output .="</tbody>";
                   	echo $output;
	} else {
		echo "<h3>Ничего не найдено</h3>";
	}




 ?>