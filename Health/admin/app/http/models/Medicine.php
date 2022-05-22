<?php

/**
* Blog Model
*/
class Medicine extends Model
{
	public function allPharmacy()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "pharmacy` ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getSuppliers()
	{
		$query = $this->database->query("SELECT id, name FROM `" . DB_PREFIX . "suppliers`");
		return $query->rows;
	}

	public function getTaxes()
	{
		$query = $this->database->query("SELECT `id`, `name`, `rate` FROM `" . DB_PREFIX . "taxes`");
		return $query->rows;
	}

	public function getMedicines()
	{
		$query = $this->database->query("SELECT m.*, mc.name AS category_name, SUM(mb.qty) AS qty, SUM(mb.qty) - SUM(mb.sold) AS livestock FROM `" . DB_PREFIX . "medicines` AS m LEFT JOIN `" . DB_PREFIX . "medicine_category` AS mc ON mc.id = m.category LEFT JOIN `" . DB_PREFIX . "medicine_batch` AS mb ON mb.medicine_id = m.id AND mb.expiry > '".date('Y-m')."' GROUP BY m.id ORDER BY m.date_of_joining DESC");
		return $query->rows;
	}

	public function getMedicine($id)
	{
		$query = $this->database->query("SELECT m.*, mc.name AS category_name FROM `" . DB_PREFIX . "medicines` AS m LEFT JOIN `" . DB_PREFIX . "medicine_category` AS mc ON mc.id = m.category WHERE m.id = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getMedicineLiveStock($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE medicine_id = ? AND expiry > ? ORDER BY medicine_id", array($id, date('Y-m')));
		return $query->rows;
	}

	public function getMedicineBadStock($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE medicine_id = ? AND expiry < ? AND qty > sold",
			array($id, date('Y-m')));
		return $query->rows;
	}

	public function updateMedicine($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "medicines` SET `name` = ?, `company` = ?, `generic` = ?, `medicine_group` = ?, `category` = ?, `storebox` = ?, `minlevel` = ?, `reorderlevel` = ?, `unit` = ?, `unitpacking` = ?, `note` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $data['company'], $data['generic'], $data['medicine_group'], (int)$data['category'], $data['storebox'], $data['minlevel'], $data['reorderlevel'], $data['unit'], $data['unitpacking'], $data['note'], (int)$data['id']));
		return true;
	}

	public function createMedicine($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "medicines` (`name`, `company`, `generic`, `medicine_group`, `category`, `storebox`, `minlevel`, `reorderlevel`, `unit`, `unitpacking`, `note`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $data['company'], $data['generic'], $data['medicine_group'], (int)$data['category'], $data['storebox'], $data['minlevel'], $data['reorderlevel'], $data['unit'], $data['unitpacking'], $data['note'], (int)$data['user_id'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteMedicine($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "medicines` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) { return true; }
		else { return false; }
	}

	public function getSearchedMedicine($data)
	{
		$query = $this->database->query("SELECT id, name AS label, generic FROM `" . DB_PREFIX . "medicines` WHERE name like '%".$data."%' LIMIT 10");
		return $query->rows;
	}


	public function getLiveStocks()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE expiry > ? AND status = 1 ORDER BY medicine_id", array(date('Y-m')));
		return $query->rows;
	}

	public function getExpiredStocks()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE expiry < ? AND status = 1 ORDER BY medicine_id", array(date('Y-m')));
		return $query->rows;
	}

	public function getWillExpireStocks($date)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE expiry < ? AND expiry > ? AND status = 1 ORDER BY medicine_id", array($date, date('Y-m')));
		return $query->rows;
	}

	public function updateStock($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "medicine_batch` SET sold = qty - ? WHERE `id` = ? AND `medicine_id` = ? ", array($data['available'], $data['id'], $data['medicine_id']));
		return true;
	}

	public function deleteStock($id)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "medicine_batch` SET status = 0 WHERE `id` = ?", array((int)$id));
		return true;
	}



	public function getMedicineBills($period)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_bill` WHERE date_of_joining BETWEEN ? AND ? ORDER BY date_of_joining DESC", array($period['start'], $period['end']));
		return $query->rows;
	}

	public function getMedicineBill($id)
	{
		$query = $this->database->query("SELECT mb.*, pm.name AS payment_method FROM `" . DB_PREFIX . "medicine_bill` AS mb LEFT JOIN `" . DB_PREFIX . "payment_method` AS pm ON pm.id = mb.method WHERE mb.id = ?", array($id));
		return $query->row;
	}

	public function getPaymentMethods()
	{
		$query = $this->database->query("SELECT id, name FROM `" . DB_PREFIX . "payment_method` WHERE status = ?", array(1));
		return $query->rows;
	}

	public function getBillingItems($id)
	{
		$query = $this->database->query("SELECT items FROM `" . DB_PREFIX . "medicine_bill` WHERE id = ?", array($id));
		return $query->row;
	}

	public function updateMedicineBatchSold($data)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE `id` = ? AND `medicine_id` = ?", array($data['batch'], $data['medicine_id']));

		if ($query->num_rows > 0) {
			$count = $query->row['sold'];
			$count = $count + (float)$data['qty'];
			
			$this->database->query("UPDATE `" . DB_PREFIX . "medicine_batch` SET sold = ? WHERE `id` = ? AND `medicine_id` = ? ", array($count, $data['batch'], $data['medicine_id']));
			return true;
		} else {
			return false;
		}
	}

	public function updateMedicineBatchSoldOnDelete($data)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE `id` = ? AND `medicine_id` = ?", array($data['batch'], $data['medicine_id']));

		if ($query->num_rows > 0) {
			$count = $query->row['sold'];
			$count = $count - (float)$data['qty'];
			
			$this->database->query("UPDATE `" . DB_PREFIX . "medicine_batch` SET `sold` = ? WHERE `id` = ? AND `medicine_id` = ? ", array($count, $data['batch'], $data['medicine_id']));
			return true;
		} else {
			return false;
		}
	}

	public function updateMedicineBill($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "medicine_bill` SET `name` = ?, `email` = ?, `mobile` = ?, `doctor` = ?, `method` = ?, `items` = ?, `subtotal` = ?, `tax` = ?, `discounttype` = ?, `discount` = ?, `discount_value` = ?, `amount` = ?, `note` = ?, `doctor_id` = ?, `patient_id` = ? WHERE `id` = ? ", array($this->database->escape($data['name']), $data['email'], $data['mobile'], $data['doctor'], (int)$data['method'], $data['items'], $data['subtotal'], $data['tax'], (int)$data['discounttype'], $data['discount'], $data['discount_value'], $data['amount'], $data['note'], (int)$data['doctor_id'], (int)$data['patient_id'], (int)$data['id']));
		return true;
	}

	public function createMedicineBill($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "medicine_bill` (`name`, `email`, `mobile`, `doctor`, `method`, `items`, `subtotal`, `tax`, `discounttype`, `discount`, `discount_value`, `amount`, `note`, `doctor_id`, `patient_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $data['email'], $data['mobile'], $data['doctor'], $data['method'], $data['items'], $data['subtotal'], $data['tax'], (int)$data['discounttype'], $data['discount'], $data['discount_value'], $data['amount'], $data['note'], (int)$data['doctor_id'], (int)$data['patient_id'], (int)$data['user_id'], $data['datetime']));
		
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteMedicineBill($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "medicine_bill` WHERE `id` = ?", array((int)$id));
	}




	public function getPurchases($period)
	{
		$query = $this->database->query("SELECT mp.*, s.name AS supplier FROM `" . DB_PREFIX . "medicine_purchase` AS mp LEFT JOIN `" . DB_PREFIX . "suppliers` AS s ON s.id = mp.supplier WHERE mp.date between '".$period['start']."' AND '".$period['end']."' ORDER BY date_of_joining DESC");
		return $query->rows;
	}

	public function getPurchaseView($id)
	{
		$query = $this->database->query("SELECT mp.*, s.name, s.email, s.phone FROM `" . DB_PREFIX . "medicine_purchase` AS mp LEFT JOIN `" . DB_PREFIX . "suppliers` AS s ON s.id = mp.supplier WHERE mp.id = ?", array($id));
		return $query->row;
	}

	public function getPurchase($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_purchase` WHERE id = ?", array($id));
		return $query->row;
	}

	public function getBatches($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE purchase_id = ?", array($id));
		return $query->rows;
	}

	public function getSearchedBatchWithMedicine($data)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE medicine_id = ? AND id = ?", array($data['medicine'], $data['batch']));
		return $query->row;
	}

	public function getSearchedBatch($data)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE medicine_id = ? AND expiry > ? AND status = 1", array($data['id'], $data['monthyear']));
		return $query->rows;
	}

	public function getBatchNameFromId($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_batch` WHERE id = ?", array($id));
		return $query->row;
	}

	public function updateMedicinePurchase($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "medicine_purchase` SET `supplier` = ?, `date` = ?, `total` = ?, `tax` = ?, `discounttype` = ?, `discount` = ?, `discount_value` = ?, `amount` = ?, `note` = ? WHERE `id` = ? ", array($this->database->escape($data['supplier']), $data['date'], $data['total'], $data['tax'], (int)$data['discounttype'], $data['discount'], $data['discount_value'], $data['amount'], $data['note'], (int)$data['id']));
		return true;
	}

	public function createMedicinePurchase($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "medicine_purchase` (`supplier`, `date`, `total`, `tax`, `discounttype`, `discount`, `discount_value`, `amount`, `note`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['supplier']), $data['date'], $data['total'], $data['tax'], (int)$data['discounttype'], $data['discount'], $data['discount_value'], $data['amount'], $data['note'], (int)$data['user_id'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function updateMedicinebatch($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "medicine_batch` SET `name` = ?, `batch` = ?, `expiry` = ?, `pqty` = ?, `qty` = ?, `saleprice` = ?, `purchaseprice` = ?, `tax` = ?, `taxprice` = ?, `price` = ?, `medicine_id` = ? WHERE `id` = ? AND `purchase_id` = ?", array($this->database->escape($data['name']), $data['batch'], $data['expiry'], $data['pqty'], (int)$data['qty'], $data['saleprice'], $data['purchaseprice'], $data['tax'], $data['taxprice'], $data['price'], $data['medicine_id'], (int)$data['id'], (int)$data['purchase_id']));
		return true;
	}

	public function createMedicinebatch($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "medicine_batch` (`name`, `batch`, `expiry`, `pqty`, `qty`, `saleprice`, `purchaseprice`, `tax`, `taxprice`, `price`, `medicine_id`, `purchase_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $data['batch'], $data['expiry'], $data['pqty'], (int)$data['qty'], $data['saleprice'], $data['purchaseprice'], $data['tax'], $data['taxprice'], $data['price'], $data['medicine_id'], $data['purchase_id'], (int)$data['user_id'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteMedicinePurchase($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "medicine_purchase` WHERE `id` = ?", array((int)$id));
		return true;
	}

	public function deletePurchaseBatche($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "medicine_batch` WHERE `purchase_id` = ?", array((int)$id));
		return true;
	}

	public function deleteBatche($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "medicine_batch` WHERE `id` = ?", array((int)$id));
		return true;
	}



	public function getMCategory()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_category`");
		return $query->rows;
	}

	public function updateMCategory($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "medicine_category` SET `name` = ? WHERE `id` = ? ", array($this->database->escape($data['name']), (int)$data['id']));
		return true;
	}

	public function createMCategory($data)
	{
		$this->database->query("INSERT INTO `" . DB_PREFIX . "medicine_category` (`name`, `date_of_joining`) VALUES (?, ?)", array($this->database->escape($data['name']), $data['datetime']));
		return true;
	}

	public function deleteMCategory($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "medicine_category` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}