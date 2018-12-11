<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 10/12/18
 * Time: 21:22
 */

namespace CodeProject\Services;


use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectFile;
use CodeProject\Repositories\ProjectFileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Filesystem\Filesystem as Storage;

class ProjectFileService {
  /**
   * @var EntityManagerInterface
   */
  private $em;
  /**
   * @var Filesystem
   */
  private $filesystem;
  /**
   * @var Storage
   */
  private $storage;

  /**
   * @var ProjectFileRepository
   */
  private $repository;

  /**
   * ProjectFileService constructor.
   * @param EntityManagerInterface $em
   * @param Filesystem $filesystem
   * @param Storage $storage
   */
  public function __construct(EntityManagerInterface $em, ProjectFileRepository $repository,
                              Filesystem $filesystem, Storage $storage) {
    $this->em = $em;
    $this->filesystem = $filesystem;
    $this->storage = $storage;
    $this->repository = $repository;
  }

  /**
   * @param Project $project
   * @param $file
   * @param $name
   * @return array
   */
  public function addFile(Project $project, UploadedFile $file, $name) {
    try {
      $extension = $file->getClientOriginalExtension();
      $success = $this->storage->put($name . "." . $extension, $this->filesystem->get($file));
      $fileObj = new ProjectFile($name, $extension, '', $project);
      $this->em->persist($fileObj);
      $this->em->flush();
      if ($success) {
        return [
          'success' => TRUE,
          'result' => 'Arquivo enviado com sucesso!'
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
  }

  /**
   * @param int $projectId
   * @param int $fileId
   * @return mixed
   * @throws \Exception
   */
  public function deleteFile(int $projectId, int $fileId) {
    try {
      $file = $this->repository->getFileFromProject($projectId, $fileId);
      if ($file) {
        $fileDb = $this->em->find(ProjectFile::class, $fileId);
        $success = $this->storage->delete($file->getName() . "." . $file->getExtension());
        if ($success) {
          $this->em->remove($fileDb);
          $this->em->flush();
        }
        return $success;
      } else {
        return FALSE;
      }
    } catch (NoResultException $e) {
        return FALSE;
    }
  }

}