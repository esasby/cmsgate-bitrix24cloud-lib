<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\Logger;
use esas\cmsgate\utils\StringUtils;
use PDO;

class ShopConfigBitrix24RepositoryPDO extends ShopConfigBitrix24Repository
{
    /**
     * @var PDO
     */
    protected $pdo;
    protected $tableName;
    /**
     * @var Logger
     */
    protected $logger;

    const COLUMN_ID = 'id';
    const COLUMN_DOMAIN = 'domain';
    const COLUMN_AUTH_TOKEN = 'auth_token';
    const COLUMN_EXPIRE_AT = 'expire_at';
    const COLUMN_REFRESH_TOKEN = 'refresh_token';
    const COLUMN_MEMBER_ID = 'member_id';

    public function __construct($pdo, $tableName = null)
    {
        $this->logger = Logger::getLogger(get_class($this));
        $this->pdo = $pdo;
        if ($tableName != null)
            $this->tableName = $tableName;
        else
            $this->tableName = Registry::getRegistry()->getModuleDescriptor()->getCmsAndPaysystemName()
                . '_auth_data';
    }

    private function createShopConfigObject($row) {
        $shopConfigBitrix24 = new ShopConfigBitrix24();
        $shopConfigBitrix24->setUuid($row[self::COLUMN_ID]);
        $shopConfigBitrix24->setDomain($row[self::COLUMN_DOMAIN]);
        $shopConfigBitrix24->setMemberId($row[self::COLUMN_MEMBER_ID]);
        $shopConfigBitrix24->setExpireAt($row[self::COLUMN_EXPIRE_AT]);
        $shopConfigBitrix24->setAccessToken(BridgeConnector::fromRegistry()->getCryptService()->decrypt($row[self::COLUMN_AUTH_TOKEN]));
        $shopConfigBitrix24->setRefreshToken(BridgeConnector::fromRegistry()->getCryptService()->decrypt($row[self::COLUMN_REFRESH_TOKEN]));
        return $shopConfigBitrix24;
    }

    public function saveOrUpdate($shopConfigBitrix24)
    {
        $sql = "select * from $this->tableName where member_id = :memberId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'memberId' => $shopConfigBitrix24->getMemberId(),
        ]);
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $uuid = $row[self::COLUMN_ID];
            $this->logger->info("Updating auth data for id[" . $uuid . "]");
            $sql = "UPDATE $this->tableName set `domain` = :dom, auth_token = :authToken, expire_at = :expireAt, refresh_token = :refreshToken where member_id = :memberId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'memberId' => $shopConfigBitrix24->getMemberId(),
                'dom' => $shopConfigBitrix24->getDomain(),
                'authToken' => BridgeConnector::fromRegistry()->getCryptService()->encrypt($shopConfigBitrix24->getAccessToken()),
                'expireAt' => $shopConfigBitrix24->getExpireAt(),
                'refreshToken' => BridgeConnector::fromRegistry()->getCryptService()->encrypt($shopConfigBitrix24->getRefreshToken())
            ]);
            return $uuid;
        }
        $uuid = StringUtils::guidv4();
        $sql = "INSERT INTO $this->tableName (id, `domain`, member_id, auth_token, expire_at, refresh_token, created_at) VALUES (:id, :dom, :memberId, :authToken, :expireAt, :refreshToken, CURRENT_TIMESTAMP)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $uuid,
            'dom' => $shopConfigBitrix24->getDomain(),
            'memberId' => $shopConfigBitrix24->getMemberId(),
            'authToken' => BridgeConnector::fromRegistry()->getCryptService()->encrypt($shopConfigBitrix24->getAccessToken()),
            'expireAt' => $shopConfigBitrix24->getExpireAt(),
            'refreshToken' => BridgeConnector::fromRegistry()->getCryptService()->encrypt($shopConfigBitrix24->getRefreshToken())
        ]);
        $this->logger->info("Auth data was saved by id[" . $uuid . "]");
        return $uuid;
    }

    public function findByMemberId($memberId)
    {
        $sql = "select * from $this->tableName where member_id = :memberId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'memberId' => $memberId,
        ]);
        $shopConfig = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $shopConfig =  $this->createShopConfigObject($row);
        }
        return $shopConfig;
    }

    public function getByUUID($cacheConfigUUID) {
        $sql = "select * from $this->tableName where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $cacheConfigUUID,
        ]);
        $configCache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $configCache =  $this->createShopConfigObject($row);
        }
        return $configCache;
    }

    public function saveConfigData($configCacheUUID, $configData) {
        throw new CMSGateException('Not implemented');
    }
}