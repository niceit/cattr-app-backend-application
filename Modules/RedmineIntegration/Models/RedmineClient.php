<?php
namespace Modules\RedmineIntegration\Models;

use Modules\RedmineIntegration\Entities\Repositories\UserRepository;

class RedmineClient extends \Redmine\Client
{
    /**
     * RedmineClient constructor.
     *
     * @param $userId
     */
    public function __construct($userId)
    {
        $userRepository = new UserRepository();
        $url = $userRepository->getUserRedmineUrl($userId);
        $apiKey = $userRepository->getUserRedmineApiKey($userId);
        $pass = null;

        if (empty($url)) {
            $e = new \Exception('Empty url');
            throw $e;
        }

        parent::__construct($url, $apiKey, $pass);
    }

}