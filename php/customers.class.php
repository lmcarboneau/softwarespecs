<?php
 /**
 * Customer Database Management Functions
 *
 */

require_once("database.class.php");
$database = new database();
 
class customers {

	public function addCustomer($id, $name, $firstname, $lastname, $address1, $address2, $city, $state, $zip, $phonenumber, $gardenerID, $monthlycharge, $averagehours, $quantityTableID, $active){
		mysql_query("INSERT INTO customers (customer_name, contact_first_name, contact_last_name, address_line_one, 
			address_line_two, city, state, zip, gardenerID, monthly_revenue, hours_to_service, quantityTableID, active) 
			VALUES (".$id.",".$name.",".$firstname.",".$lastname.",".$address1.",".$address2.",".$city.","
					.$state.",".$zip.",".$phonenumber.",".$gardenerID.",".$monthlycharge.",".$averagehours.",".$quantityTableID.",".$active");");
	}

	public function editCustomer($id, $name, $firstname, $lastname, $address1, $address2, $city, $state, $zip, $phonenumber, $gardenerID, $monthlycharge, $averagehours, $quantityTableID, $active){
		mysql_query("UPDATE customers (customer_name, contact_first_name, contact_last_name, address_line_one, 
			address_line_two, city, state, zip, gardenerID, monthly_revenue, hours_to_service, quantityTableID, active) 
			SET (".$id.",".$name.",".$firstname.",".$lastname.",".$address1.",".$address2.",".$city.","
					.$state.",".$zip.",".$phonenumber.",".$gardenerID.",".$monthlycharge.",".$averagehours.",".$quantityTableID.",".$active")
			WHERE id = ".$id.";";
	}

	public function removeCustomer($id){
		mysql_query("DELETE FROM customers WHERE id = ".$id.";";
	}

	public function getCustomerList(){
		mysql_query("SELECT * FROM customers;";
	}

	public function getCustomer($id){
		mysql_query("SELECT * FROM customers WHERE id = "$.id.";";
	}

}
?>