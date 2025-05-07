<?php

namespace App\Controller;

use App\Entity\Entradas;
use App\Repository\EntradasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;    //original
use Symfony\Component\Routing\Annotation\Route;     //copiado de AP9 del profe



#[Route('/entradas', name: 'app_entradas')]
final class EntradasController extends AbstractController
{

    private EntradasRepository $entradasRepository;

    public function __construct(EntradasRepository $entrada)
    {
        $this->entradasRepository = $entrada; 
    }

    #[Route('/', name: 'app_main')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EntradasController.php',
        ]);
    }

    #[Route('/new', name:'api_entradas_new',methods:['POST'])]
    public function add(Request $request):JsonResponse
    {
        $data = json_decode($request->getContent());

        /*$this->entradasRepository->new($data->email, 
                                       $data->precio, 
                                       $data->ocupado, 
                                       $data->numero_de_asiento);
        */

        $nuevaEntrada = new Entradas();   
        $nuevaEntrada->setEmail($data->email);
        $nuevaEntrada->setPrecio($data->precio);
        $nuevaEntrada->setOcupado($data->ocupado);
        $nuevaEntrada->setNumeroDeAsiento($data->numeroDeAsiento);                                    
        $this->entradasRepository->save($nuevaEntrada, true);
        return new JsonResponse(['status' => 'Entrada creada'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_entradas_show', methods:['GET'])]
    public function show(Entradas $entrada):JsonResponse
    {
        $data = [
            'id' => $entrada->getId(),
            'email' => $entrada->getEmail(),
            'precio' => $entrada->getPrecio(),
            'ocupado' => $entrada->isOcupado(),
            'numero_de_asiento' => $entrada->getNumeroDeAsiento(),
            'fecha' => $entrada->getFecha()
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/edit/{id}', name: 'app_entradas_edit', methods:['PUT','PATCH'])]
    public function edit($id, Request $request): JsonResponse
    {
        $entrada = $this->entradasRepository->find($id);
        //Recibimos los datos como si fueran un objeto
        $data = json_decode($request->getContent());
        if($_SERVER['REQUEST_METHOD']=='PUT')
            $mensaje = 'Tarea actualizada completamente de forma satisfactoria';
        else
            $mensaje = 'Tarea actualizada parcialmente de forma satisfactoria';
        //Utilizamos el operador ternario 
        empty($data->email) ? true : $entrada->setEmail($data->email);
        empty($data->precio) ? true : $entrada->setPrecio($data->precio);
        empty($data->ocupado) ? true : $entrada->setOcupado($data->ocupado);
        empty($data->numeroDeAsiento) ? true : $entrada->setNumeroDeAsiento($data->numeroDeAsiento);
        $this->entradasRepository->save($entrada,true);
        return new JsonResponse(['status'=>$mensaje], Response::HTTP_CREATED);
    }

    #[Route('/delete/{id}', name:"app_entradas_delete", methods:['DELETE'])]
    public function remove(Entradas $entrada): JsonResponse
    {
        $email = $entrada->getEmail();
        $this->entradasRepository->remove($entrada, true);
        return new JsonResponse(['status'=>'Tarea ' . $email . ' borrada'], Response::HTTP_OK);
    }
}
