<?php

namespace Vikuraa\Modules\Customers;

use Vikuraa\Core\Controller;
use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Attributes as OA;
use Slim\Exception\HttpBadRequestException;
use Vikuraa\Helpers\Functions;

class CustomerController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $model = new CustomerModel($this->container);

        $data = $model->all();

        return $response->withJson([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function byId(Request $request, Response $response, array $args)
    {
        $customerId = $args['customerId'];
        if ($customerId == null || !is_int(intval($customerId))) {
            throw new HttpBadRequestException($request, 'Customer ID is required and should be integer');
        }

        $model = new CustomerModel($this->container);

        $customer = $model->byId($customerId);

        return $response->withJson([
            'status' => 'success',
            'data' => $customer->toArray(),
        ]);
    }

    public function search(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $query = $body['query'] ?? null;
        $limit = $body['limit'] ?? 0;
        $offset = $body['offset'] ?? 0;
        $sort = $body['sort'] ?? 'first_name';
        $order = $body['order'] ?? 'asc';

        if ($query == null) {
            throw new HttpBadRequestException($request, 'Query is required');
        }

        $model = new CustomerModel($this->container);

        $data = $model->search($query, $limit, $offset, $sort, $order);

        return $response->withJson([
            'status' => 'success',
            'data' => $data->toArrayDeep()
        ]);
    }

    public function save(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        if (empty($body['first_name']) || empty($body['last_name']) || $body['consent'] === null) {
            throw new HttpBadRequestException($request, 'First name, last name and consent are required');
        }

        $body['person_id'] = 0;
        $customer = Customer::fromDbArray([
            'person_id'         => $body['person_id'],
            'account_number'    => $body['account_number'],
            'address_1'         => $body['address_1'],
            'address_2'         => $body['address_2'],
            'city'              => $body['city'],
            'comments'          => empty($body['comments']) ? '-' : $body['comments'],
            'company'           => $body['company'],
            'consent'           => boolval($body['consent']),
            'country'           => $body['country'],
            'discount'          => floatval($body['discount']),
            'discount_type'     => $body['discount_type'],
            'email'             => $body['email'],
            'first_name'        => $body['first_name'],
            'gender'            => $body['gender'],
            'last_name'         => $body['last_name'],
            'phone_number'      => $body['phone_number'],
            'state'             => $body['state'],
            'tax_id'            => $body['tax_id'],
            'taxable'           => boolval($body['taxable']),
            'zip'               => $body['zip']
        ]);
        $this->logger->debug('saving customer', $customer->toArray());

        $model = new CustomerModel($this->container);
        $result = $model->save($customer);
        if ($result) {
            return $response->withJson([
                'status' => 'success',
                'message' => 'Customer saved successfully'
            ]);
        }

        return $response->withJson([
            'status' => 'error',
            'message' => 'Could not save customer'
        ]);
    }
}
