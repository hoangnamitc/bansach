<?php 
	mysql_query("set names 'utf8'");   
	$query = "SELECT COUNT(*) as num FROM $tableName";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];

	$stages = 1;// So nut trang chia deu 2 ben cua trang hien tai
	//Dat dieu kien cho so trang hien tai
	 if(isset($_GET['page']) && $_GET['page'] <= $total_pages && (int)$_GET['page'])
	{
		$page = mysql_real_escape_string($_GET['page']);
	}
	else 
	{
		$page = 1;
	}
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
	}	

	// Get page data
		$query1 = "SELECT * FROM $tableName LIMIT $start, $limit";
		$result = mysql_query($query1) or die("Cannot Select table !");

	// Thiết lập Số trang đầu tiên
	if ($page == 0){$page = 1;}
		$prev = $page - 1;	
		$next = $page + 1;							
		$lastpage = ceil($total_pages/$limit);		
		$LastPagem1 = $lastpage - 1;					


	$paginate = '';
	if($lastpage > 1)
	{	
		$paginate .= "<div class='paginate'>";
		// Previous
		if ($page > 1) {
			$paginate.= "<a href='$targetpage?page=$prev'>« Trước</a>";
		} else {
			$paginate.= "<span class='disabled'>« Trước</span>";	
		}

	// Pages	** < 7 ***
	if ($lastpage < 7 + ($stages * 2))	// Không đủ trang để phá vỡ nó ra
	{	
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page){
				$paginate.= "<span class='current'>$counter</span>";
			}else{
				$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
			}
		}
	elseif($lastpage > 5 + ($stages * 2))	// Trang đủ để ẩn một vài?
	{
	// Bắt đầu ẩn các trang sau
	if($page < 1 + 3/*($stages * 2)*/)		
	{
		for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
		{
			if ($counter == $page){
				$paginate.= "<span class='current'>$counter</span>";
			}else{
				$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
			}
			$paginate.= "...";
			$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
			$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
		}
	// Trung giấu mặt trước và một số trở lại
		elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
		{
			$paginate.= "<a href='$targetpage?page=1'>1</a>";
			$paginate.= "<a href='$targetpage?page=2'>2</a>";
			$paginate.= "...";
			for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<span class='current'>$counter</span>";
				}else{
					$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
			}
	// Chỉ kết thúc ẩn trang đầu
			else
			{
				$paginate.= "<a href='$targetpage?page=1'>1</a>";
				$paginate.= "<a href='$targetpage?page=2'>2</a>";
				$paginate.= "...";
				// (2 + ($stages * 2));
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
					}
				}
			}
			
		// Next
			if ($page < $counter - 1){ 
				$paginate.= "<a href='$targetpage?page=$next'>Sau »</a>";
			}else{
				$paginate.= "<span class='disabled'>Sau »</span>";
			}

			$paginate.= "</div>";		


		}
		// Hien thi du lieu

 ?>