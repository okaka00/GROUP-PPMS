<?php
session_start();
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>My Product Portfolio Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/newstyle.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="includes/modalAuth.js"></script>
</head>

<body>
	<!-- User Nav Section -->
	<?php include("includes/userNav.php"); ?>

	<!-- Main Container -->
	<div class="container">
		<!-- Navigation Menu -->
		<?php
		include("includes/topNav.php");
		include("userAuth/modalForm.php");

			// Check if user is logged in
			if (!isset($_SESSION["UID"])) {
				echo '<script>
						document.addEventListener("DOMContentLoaded", function() {
							openLoginPopup();
						});
					</script>';
				exit;
			} else {
				$userID = $_SESSION["UID"];
			}
		?>

		<div class="section">
			<p style="margin: 15px;"><i class="fa fa-shopping-cart" style="font-size:24px"></i> / My Order</p>

			<?php
			$sql = "SELECT * FROM reservation WHERE userID = '$userID' ORDER BY reservationID DESC";
			$result1 = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result1) > 0) {
				while ($row1 = mysqli_fetch_assoc($result1)) {
			?>
					<p></p>
					<table cellpadding="10" cellspacing="1" id="blogtable" width="100%" style="margin: 0 10px 0 10px;">
						<tr>
							<th
								style="padding-top: 12px; padding-bottom: 12px; text-align: center; background-color: #824554; color: white;">
								Order ID</th>
							<th
								style="padding-top: 12px; padding-bottom: 12px; text-align: center; background-color: #824554; color: white;">
								Order Date Time</th>
							<th
								style="padding-top: 12px; padding-bottom: 12px; text-align: center; background-color: #824554; color: white;">
								Order Status</th>
							<th
								style="padding-top: 12px; padding-bottom: 12px; text-align: center; background-color: #824554; color: white;">
								Order Amount (RM)</th>
						</tr>
						<tr>
							<td style="text-align:center;"><?php echo $row1["reservationID"]; ?></td>
							<td style="text-align:center;"><?php echo date("d/m/Y", strtotime($row1["reservationDate"])); ?></td>
							<td style="text-align:center;">
								<?php
									if ($row1["status"] == 1) {
										echo '<span style="color: red;">Pending</span>';
									} elseif ($row1["status"] == 2) {
										echo '<span style="color: green;">Complete</span>';
									} else {
										echo $row1["status"];
									}
									?>
							<td style="text-align:center;"><?php echo number_format($row1["orderAmt"], 2); ?></td>
						</tr>
					</table>

					<?php
					$sql2 = "SELECT p.productID, p.productName, rd.orderQuantity
                             FROM reservation_detail rd, product p 
                             WHERE rd.productID = p.productID 
                             AND rd.reservationID = '" . $row1["reservationID"] . "'";
					$result2 = mysqli_query($conn, $sql2);

					if (mysqli_num_rows($result2) > 0) {
						$itemNum = 0;
						?>
						<table cellpadding="10" cellspacing="1" id="blogtable" width="100%" style="margin: 0 10px 0 10px;">
							<tbody>
								<tr>
									<th width="15%" style="background-color: #909090; color: white; text-align: center;">Item #</th>
									<th width="15%" style="background-color: #909090; color: white; text-align: center;">Item Name
									</th>
									<th width="15%" style="background-color: #909090; color: white; text-align: center;">Quantity
									</th>
									<th width="15%" style="background-color: #909090; color: white; text-align: center;">Review</th>
								</tr>
								<?php
								while ($row2 = mysqli_fetch_assoc($result2)) {
									$itemNum++;
									$query = "SELECT reviewID FROM review WHERE reservationID = '" . $row1["reservationID"] . "' AND productID ='" . $row2["productID"] . "'";
									$review = mysqli_query($conn, $query);
									if (mysqli_num_rows($review) > 0) {
										$reviewFlag = "Y";
									} else {
										$reviewFlag = "N";
									}
								?>
									<tr>
										<td style="text-align:center;"><?php echo $itemNum ?></td>
										<td style="text-align:center;"><?php echo $row2["productName"]; ?></td>
										<td style="text-align:center;"><?php echo $row2["orderQuantity"]; ?></td>
										<td style="text-align:center;">
											<?php
											if ($reviewFlag == "Y") {
												echo '<span style="color: green;"><i class="fa fa-check-circle-o"></i> You have reviewed this item</span>';
											} else {
												echo '<span style="color: red;">Not Reviewed</span>';
												echo '<a href="review.php?productID=' . $row2["productID"] . '&rd-id=' . $row1["reservationID"] . '&productName=' . $row2["productName"] . '">' . '<i class="fa fa-comment"></i> Review</a>';
											}
											?>
										</td>
									</tr>
								<?php
								}
								
								?>
							</tbody>
						</table>
						<?php
						mysqli_free_result($result2);
					}
				}
				mysqli_free_result($result1);
			} else {
				echo '<p style="margin: 15px;">Your Order is Empty</p>';
			}
			mysqli_close($conn);
			?>
		</div>
	</div>

	<footer class="footer">
		<p><small><i>Copyright &copy; 2024 FCI</i></small></p>
	</footer>
</body>

</html>