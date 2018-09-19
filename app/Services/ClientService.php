<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 07/08/18
 * Time: 15:21
 */

namespace CodeProject\Services;


use CodeProject\Entities\Doctrine\Client;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService {
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;

    private $em;

    public function __construct(EntityManagerInterface $em, ClientRepository $repository, ClientValidator $validator)  {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->em = $em;
    }
    public function create(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();
            //Doctrine
            $client = new Client();
            $client->setName($data['name']);
            $client->setResponsible($data['responsible']);
            $client->setEmail($data['email']);
            $client->setAddress($data['address']);
            $client->setObs($data['obs']);
            $client->setPhone($data['phone']);
            $this->em->persist($client);
            $this->em->flush();
            return $client;
            //Eloquent
            //return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessageBag()
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessage()
            ];
        }
    }

    public function update(array $data, $id) {
        try {
            $this->validator->with($data)->passesOrFail();
            $client = $this->repository->find($id);
            if ($client) {
                $client->setName($data['name']);
                $client->setResponsible($data['responsible']);
                $client->setEmail($data['email']);
                $client->setAddress($data['address']);
                $client->setObs($data['obs']);
                $client->setPhone($data['phone']);
                $this->em->merge($client);
                $this->em->flush();
                return $client;
            } else {
                throw new EntityNotFoundException('Cliente não encontrado!');
            }
//            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessageBag()
            ];
        } catch (ModelNotFoundException $e) {
            return json_encode([
                'success' => FALSE,
                'result' => 'Cliente não encontrado!'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return [
               'success' => FALSE,
               'result' => "Erro ao atualizar: {$e->getMessage()}"
            ];
        }

    }

}