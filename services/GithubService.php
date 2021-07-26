<?php

namespace app\services;

use app\models\GithubRepository;
use app\models\GithubUser;
use Yii;
use Exception;
use KubAT\PhpSimple\HtmlDomParser;
use simple_html_dom\simple_html_dom_node;
use simple_html_dom\simple_html_dom;

class GithubService
{
    const URL_PREFIX = 'https://github.com';

    /**
     * @var ParseService
     */
    protected $parseService;

    /**
     * GithubService constructor.
     *
     * @param ParseService $parseService
     */
    public function __construct(ParseService $parseService)
    {
        $this->parseService = $parseService;
    }

    /**
     * @throws \yii\db\Exception
     *
     * return void
     */
    public function parseRepositories()
    {
        Yii::$app->db->createCommand()->truncateTable('github_repository')->execute();

        $githubUsers = GithubUser::find()->all();

        foreach ($githubUsers as $githubUser) {
           $this->parseGithubRepositories($githubUser);
        }
    }

    /**
     * @param GithubUser $githubUser
     *
     * @return void
     */
    public function parseGithubRepositories(GithubUser $githubUser)
    {
        $linkFirstPage = sprintf('%s/%s?tab=repositories', self::URL_PREFIX, $githubUser->name);
        $linkCurrentPage = $linkFirstPage;

        while (!empty($linkCurrentPage)) {
            $this->parseOnePageRep($githubUser, $linkCurrentPage);

            $linkCurrentPage = $this->parseLinkOnNextPage($linkCurrentPage);
        }
    }

    /**
     * @param string $linkOnCurrentPage
     *
     * @return string | null
     */
    public function parseLinkOnNextPage(string $linkOnCurrentPage): ?string
    {
        try {
            echo "Parse link on next page" . PHP_EOL;

            $dom = HtmlDomParser::file_get_html($linkOnCurrentPage);
            $btnGroup = $this->parseContainer($dom, ['.BtnGroup']);
            $aTag = $this->parseContainer($btnGroup, ['a.BtnGroup-item']);

            $buttonText = $aTag->plaintext;
            if ($buttonText != 'Next') {
                $aTag = $this->parseContainer($btnGroup, [['tag' => 'a.BtnGroup-item', 'key' => 1]]);
            }
            $buttonText = $aTag->plaintext;
            $link = $aTag->attr['href'];

            sleep(1);

            return $link;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param GithubUser $githubUser
     * @param string $pageLink
     *
     * @return array of GithubRepository
     */
    public function  parseOnePageRep(GithubUser $githubUser, string $pageLink): array
    {
        try {
            echo "Parse githubUser ".$githubUser->name. PHP_EOL;

            $dom = HtmlDomParser::file_get_html($pageLink);
            $boxItems = $this->parseContainer($dom, ['#user-repositories-list>ul'])->children;

            $repositories = [];
            foreach ($boxItems as $item) {
                $cloneItem = clone $item;

                $a = $this->parseContainer($item, ['div', 'div', 'h3', 'a']);

                $href = $a->attr['href'];

                $lastUpdate = $this->parseContainer($cloneItem, ['relative-time'])->attr['datetime'];

                $data['url'] = $href;
                $data['github_user_id'] = $githubUser->id;
                $data['last_update'] = $lastUpdate;

                echo 'Repository parsing ' . $data['url'] . ' is finished' . PHP_EOL;

                $repositories[] = GithubRepository::create($data);

                sleep(1);
            }

            return $repositories;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * @param simple_html_dom | simple_html_dom_node $dom
     * @param array $containers
     *
     * @return simple_html_dom_node
     *
     * @throws Exception
     */
    public function parseContainer($dom, array $containers): simple_html_dom_node
    {
        return $this->parseService->parseContainer($dom, $containers);
    }
}
