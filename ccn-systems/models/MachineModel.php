<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 24.02.17
 * Time: 9:17
 */

namespace Models;

use Core\View;
use Core\Db;
use Controllers\UserController;
use PDO;


class MachineModel
{
    protected $db;
    private $hubId;
    private $customerId;
    private $organisation;
    private $installationDate;
    private $installationCity;
    private $installationStreet;
    private $installationHouseNumber;
    private $inventoryNumber;
    private $installerName;
    private $firmwareStatus;


    public function getHubId()
    {
        return $this->hubId;
    }

    public function setHubId($hubId)
    {
        $this->hubId = $hubId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    public function getOrganisation()
    {
        return $this->organisation;
    }

    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }

    public function getInstallationDate()
    {
        return $this->installationDate;
    }

    public function setInstallationDate($installationDate)
    {
        $this->installationDate = $installationDate;
    }

    public function getInstallationCity()
    {
        return $this->installationCity;
    }

    public function setInstallationCity($installationCity)
    {
        $this->installationCity = $installationCity;
    }

    public function getInstallationStreet()
    {
        return $this->installationStreet;
    }

    public function setInstallationStreet($installationStreet)
    {
        $this->installationStreet = $installationStreet;
    }

    public function getInstallationHouseNumber()
    {
        return $this->installationHouseNumber;
    }

    public function setInstallationHouseNumber($installationHouseNumber)
    {
        $this->installationHouseNumber = $installationHouseNumber;
    }

    public function getInventoryNumber()
    {
        return $this->inventoryNumber;
    }

    public function setInventoryNumber($inventoryNumber)
    {
        $this->inventoryNumber = $inventoryNumber;
    }

    public function getInstallerName()
    {
        return $this->installerName;
    }

    public function setInstallerName($installerName)
    {
        $this->installerName = $installerName;
    }

    public function getFirmwareStatus()
    {
        return $this->firmwareStatus;
    }

    public function setFirmwareStatus($firmwareStatus)
    {
        $this->firmwareStatus = $firmwareStatus;
    }

    public function __construct() {
        $this->db = Db::connect();
    }

    public static function getDevicesByCustomer($customerId){
        $db = Db::connect();
        $stmt = $db->prepare("SELECT * FROM devices WHERE
customer_id = '$customerId'");
        $stmt->execute();
        $devices = $stmt->fetch(PDO::FETCH_ASSOC);
        return $devices;
    }


}