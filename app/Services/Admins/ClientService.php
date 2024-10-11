<?php

namespace App\Services\Admins;

use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientService
{
    protected $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getPaginatedClient()
    {
        try {
            return $this->client->orderByDesc('created_at')->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to get paginated client list: ' . $e->getMessage());
            throw new Exception('Failed to get paginated client list');
        }
    }

    public function getAllClient()
    {
        try {
            return $this->client->orderByDesc('created_at')->get();
        } catch (Exception $e) {
            Log::error('Failed to get client list: ' . $e->getMessage());
            throw new Exception('Failed to get client list');
        }
    }

    public function getClientById($id)
    {
        try {
            return $this->client->find($id);
        } catch (Exception $e) {
            Log::error('Failed to find this client: ' . $e->getMessage());
            throw new Exception('Failed to find this client');
        }
    }

    public function getClientByName($name)
    {
        try {
            return $this->client->where('name', 'LIKE', '%' . $name . '%')->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to find this client by name: ' . $e->getMessage());
            throw new Exception('Failed to find this client by name');
        }
    }

    public function getClientByPhone($phone)
    {
        try {
            return $this->client->where('phone', 'LIKE', '%' . $phone . '%')->get();
        } catch (Exception $e) {
            Log::error('Failed to find this client by phone: ' . $e->getMessage());
            throw new Exception('Failed to find this client by phone');
        }
    }
    public function addNewClientByLink(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('Creating new client');
            $client = $this->client->create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'company_name' => $data['company_name'],
                'tax_number' => $data['tax_number'],
                'address' => $data['address'],
                'field' => $data['field'],
                'source' => 1,
            ]);

            DB::commit();
            return $client;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to add new client by link: " . $e->getMessage());
            throw new Exception('Failed to add new client by link');
        }
    }
    public function addNewClient(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('Creating new client');
            $client = $this->client->create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'company_name' => $data['company_name'],
                'tax_number' => $data['tax_number'],
                'address' => $data['address'],
                'field' => $data['field'],
                'source' => 0,
            ]);

            DB::commit();
            return $client;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to add new client: " . $e->getMessage());
            throw new Exception('Failed to add new client');
        }
    }

    public function updateClient(array $data, $id)
    {
        DB::beginTransaction();
        try {
            $client = $this->getClientById($id);
            if (!$client) {
                throw new Exception('Cannot find this client');
            }

            $client->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'company_name' => $data['company_name'],
                'tax_number' => $data['tax_number'],
                'address' => $data['address'],
            ]);

            DB::commit();
            return $client;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update this client profile: ' . $e->getMessage());
            throw $e; // Re-throw the exception for further handling
        }
    }

    public function deleteClient($id)
    {
        DB::beginTransaction();
        try {
            $client = $this->getClientById($id);
            $client->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete this client profile: ' . $e->getMessage());
            throw new Exception('Failed to delete this client profile');
        }
    }
}
