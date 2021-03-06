<?php

use Codeception\Example;
use Codeception\Util\HttpCode;
use app\fixtures\CreditWorklogFixture;
use app\fixtures\OauthAccessTokensFixture;

/**
 * Cest to stage resource.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditWorklogCest extends \tecnocen\roa\test\AbstractResourceCest
{
    protected function authToken(ApiTester $I)
    {
        $I->amBearerAuthenticated(OauthAccessTokensFixture::SIMPLE_TOKEN);
    }

    public function fixtures(ApiTester $I)
    {
        $I->haveFixtures([
            'access_tokens' => OauthAccessTokensFixture::class,
            'credit_worklog' => CreditWorklogFixture::class,
        ]);
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider indexDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function index(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve list of Credit Worklog records.');
        $this->internalIndex($I, $example);
    }

    /**
     * @return array<string,array> for test `index()`.
     */
    protected function indexDataProvider()
    {
        return [
            'list' => [
                'url' => '/v1/credit/1/worklog',
                'httpCode' => HttpCode::OK,
                'headers' => [
                    'X-Pagination-Total-Count' => 4,
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider viewDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function view(ApiTester $I, Example $example)
    {
        $I->wantTo('Retrieve Credit Worklog single record.');
        $this->internalView($I, $example);
    }

    /**
     * @return array<string,array<string,string>> data for test `view()`.
     */
    protected function viewDataProvider()
    {
        return [
            'single record' => [
                'url' => '/v1/credit/1/worklog/1',
                'data' => [
                    'expand' => 'process',
                ],
                'httpCode' => HttpCode::OK,
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider createDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function create(ApiTester $I, Example $example)
    {
        $I->wantTo('Create a Credit Worklog record.');
        $this->internalCreate($I, $example);
    }

    /**
     * @return array<string,array> data for test `create()`.
     */
    protected function createDataProvider()
    {
        return [
            'create worklog' => [
                'urlParams' => [
                    'process_id' => 1
                ],
                'data' => [
                    'stage_id' => 5
                ],
                'httpCode' => HttpCode::CREATED,
            ],
            'unprocessable worklog' => [
                'urlParams' => [
                    'process_id' => 1
                ],
                'data' => [
                    'stage_id' => 1
                ],
                'httpCode' => HttpCode::UNPROCESSABLE_ENTITY,
                'validationErrors' => [
                    'stage_id' => 'There is no transition for the current stage',
                ],
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider updateDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function update(ApiTester $I, Example $example)
    {
        $I->wantTo('Update a Credit Worklog record.');
        $this->internalUpdate($I, $example);
    }

    /**
     * @return array<string,array> data for test `update()`.
     */
    protected function updateDataProvider()
    {
        return [
            'update credit 1' => [
                'url' => '/v1/credit/1/worklog/1',
                'data' => [
                    'stage_id' => 3
                ],
                'httpCode' => HttpCode::OK,
            ],
        ];
    }

    /**
     * @param  ApiTester $I
     * @param  Example $example
     * @dataprovider deleteDataProvider
     * @depends fixtures
     * @before authToken
     */
    public function delete(ApiTester $I, Example $example)
    {
        $I->wantTo('Delete a Credit Worklog record.');
        $this->internalDelete($I, $example);
    }

    /**
     * @return array[] data for test `delete()`.
     */
    protected function deleteDataProvider()
    {
        return [
            'credit worklog not found' => [
                'url' => '/v1/credit/1/worklog/32',
                'httpCode' => HttpCode::NOT_FOUND,
            ],
            'delete credit worklog 1' => [
                'url' => '/v1/credit/1/worklog/1',
                'httpCode' => HttpCode::NO_CONTENT,
            ],
            'not found' => [
                'url' => '/v1/credit/1/worklog/1',
                'httpCode' => HttpCode::NOT_FOUND,
                'validationErrors' => [
                    'name' => 'The record "1" does not exists.'
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function recordJsonType()
    {
        return [
            'id' => 'integer:>0',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getRoutePattern()
    {
        return 'v1/credit/<process_id:\d+>/worklog';
    }
}
