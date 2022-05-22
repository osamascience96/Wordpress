<?php

/**
* Upload Controller
*/
class UploadController extends Controller
{
	public function notUpload()
	{
		echo "1";
	}

	public function getMedia()
	{
		$this->load->model('upload');
		$result = $this->model_upload->getMedia();
		$data = '';
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$size = getimagesize(URL.'public/uploads/'.$value['media']);
				$data .= '<div class="block">
				<a class="remove" data-toggle="tooltip" data-placement="top" title="Remove"><i class="ti-trash"></i></a>
				<input type="hidden" class="block-id" value="'.$value['id'].'">
				<div class="picture">
				<img src="'.URL.'public/uploads/'.$value['media'].'" title="'.$value['media'].'">
				<input type="radio" id="'.$value['media'].'" value="'.$value['media'].'">
				<label for="'.$value['media'].'">'.$value['media'].'</label>
				</div>
				<label class="font-12">Image Size : '.$size[0].'*'.$size[1].'</label>
				</div>';
			}
		}
		echo $data;
	}

	public function attachDocuments()
	{
		$data = $this->url->post;
		$data['user_id'] = $this->session->data['user_id'];

		$file = $this->url->files['file'];
		$data['ext'] = pathinfo($file['name'], PATHINFO_EXTENSION);

		$data['filedir'] = DIR.'public/uploads/attachments/';
		$data['file_name'] = 'Doc-'.uniqid(rand()).$data['id'];
		$data['file'] = $data['file_name'].'.'.$data['ext'];

		$filesystem = new Filesystem();

		$result = $filesystem->moveUpload($file, $data);
		if ($result['error'] === false) {
			$data['name'] = $result['name'];
			$data['datetime'] = date('Y-m-d H:i:s');
			$this->load->model('upload');
			$this->model_upload->createAttachments($data);
			$result['ext'] = $data['ext'];
			echo json_encode($result);
		} else {
			echo json_encode($result);
		}
	}

	public function attachDocumentsDelete()
	{
		$file = $this->url->post('name');
		if (!is_string($file)) {
			echo json_encode(array("error" => true, "message" => "File is wrong or does not exist."));
			exit();
		}

		if (!unlink(DIR.'/public/uploads/attachments/'.$file)) {
			echo json_encode(array("error" => true, "message" => "Error deleting ".$file));
			exit();
		} else {
			$data['name'] = $this->url->post('name');
			$data['type_id'] = $this->url->post('id');
			$data['type'] = $this->url->post('type');
			$this->load->model('upload');
			$result = $this->model_upload->deleteAttachments($data);
			echo json_encode(array("error" => false, "message" => "File deleted successfully."));
		}
		exit();
	}

	public function uploadMedia()
	{
		$data = $this->url->post;
		$data['user_id'] = $this->session->data['user_id'];

		$file = $this->url->files['file'];
		$data['ext'] = pathinfo($file['name'], PATHINFO_EXTENSION);

		$data['filedir'] = DIR.'public/uploads/';
		$data['file_name'] = 'media-'.uniqid(rand());
		$data['file'] = $data['file_name'].'.'.$data['ext'];

		$filesystem = new Filesystem();
		$result = $filesystem->moveUpload($file, $data);
		if ($result['error'] === false) {
			$data['name'] = $result['name'];
			$data['datetime'] = date('Y-m-d H:i:s');
			$this->load->model('upload');
			$result['id'] = $this->model_upload->createMedia($data);
			$size = getimagesize(URL.'public/uploads/'.$result['name']);
			$result['media'] = '<div class="block">
				<a class="remove" data-toggle="tooltip" data-placement="top" title="Remove"><i class="ti-trash"></i></a>
				<input type="radio" class="block-id" value="'.$result['id'].'">
				<div class="picture">
				<img src="'.URL.'public/uploads/'.$result['name'].'" title="'.$result['name'].'">
				<input type="radio" id="'.$result['name'].'" value="'.$result['name'].'">
				<label for="'.$result['name'].'">'.$result['name'].'</label>
				</div>
				<label class="font-12">Image Size : '.$size[0].'*'.$size[1].'</label>
				</div>';
			echo json_encode($result);
		} else {
			echo json_encode($result);
		}
	}

	public function mediaDelete()
	{
		$data = $this->url->post;
		$data['id'] = (int)$data['id'];
		if (!is_string($data['name'])) {
			echo json_encode(array("error" => true, "message" => "File name is wrong or does not exist."));
			exit();
		}
		if (empty($data['id']) && !is_int($data['id'])) {
			echo json_encode(array("error" => true, "message" => "File name is wrong or does not exist."));
			exit();
		}
		$this->load->model('upload');
		if (!$this->model_upload->isMedia($data)) {
			echo json_encode(array("error" => true, "message" => "File is wrong or does not exist."));
			exit();
		}

		if (!unlink(DIR.'/public/uploads/'.$data['name'])) {
			echo json_encode(array("error" => true, "message" => "Error deleting ".$file));
			exit();
		} else {
			$this->model_upload->deleteMedia($data);
			echo json_encode(array("error" => false, "message" => "File deleted successfully."));
		}
		exit();
	}

	public function indexGallery()
	{
		$file = $this->url->files['file'];

		$data['ext'] = pathinfo($file['name'], PATHINFO_EXTENSION);

		$data['filedir'] = DIR.'public/images/gallery/';
		$data['file_name'] = 'gallery-'.uniqid(rand());
		$data['file'] = $data['file_name'].'.'.$data['ext'];

		$filesystem = new Filesystem();
		$result = $filesystem->moveUpload($file, $data);
		
		if ($result['error'] === false) {
			$data['name'] = $result['name'];
			$data['user_id'] = $this->session->data['user_id'];
			$data['datetime'] = date('Y-m-d H:i:s');
			$this->load->model('upload');
			$result['id'] = $this->model_upload->createGallery($data);
			$result['error'] = false;
			$result['file'] = $data['file'];
			echo json_encode($result);
		} else {
			echo json_encode($result);
		}
	}

	public function indexGalleryDelete()
	{
		$data = $this->url->post;
		$data['id'] = (int)$data['id'];
		if (!is_string($data['name'])) {
			echo json_encode(array("error" => true, "message" => "File is wrong or does not exist."));
			exit();
		}

		if (empty($data['id']) && !is_int($data['id'])) {
			echo json_encode(array("error" => true, "message" => "File is wrong or does not exist."));
			exit();
		}
		$this->load->model('upload');
		if (!$this->model_upload->isGallery($data)) {
			echo json_encode(array("error" => true, "message" => "File is wrong or does not exist."));
			exit();
		}

		if (!unlink(DIR.'/public/images/gallery/'.$data['name'])) {
			echo json_encode(array("error" => true, "message" => "Error deleting ".$file));
			exit();
		} else {
			$this->model_upload->deleteGallery($data);
			echo json_encode(array("error" => false, "message" => "File deleted successfully."));
		}
		exit();
	}

	protected function deleteMedia()
	{
		$file = $this->url->post('name');

		if (!is_string($file)) {
			echo "Invalid file name!";
			exit();
		}
		
		if (!unlink('../public/uploads/'.$file))
		{
			echo ("Error deleting $file");
		}
		else
		{
			echo 1;
		}
	}

	protected function deleteGallery()
	{
		echo "string";
		exit();
		$file = $this->url->post('name');
		if (!is_string($file)) {
			echo "Invalid file name!";
			exit();
		}
		if (!unlink('../public/images/gallery/'.$file))
		{
			echo ("Error deleting $file");
		}
		else
		{
			echo 1;
		}
	}

	protected function validateField()
	{
		if ( (strlen($this->url->post('page')) == 6 ) || is_string($this->url->post('page'))) {
			return true;
		} elseif (is_string($this->url->post('name'))) {
			return true;
		}
		else {
			return false;
		}
	}
}