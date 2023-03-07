<?php

namespace App\Core\Application\ImageUpload;

use App\Exceptions\UserException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUpload
{
    private UploadedFile $uploaded_file;
    private array $available_type;
    private array $available_mime_type;
    private int $file_size_limit;
    private string $path;
    private string $seed;
    private string $name;

    public function __construct(UploadedFile $uploaded_file, string $path, string $seed, string $name) {
        $this->uploaded_file = $uploaded_file;
        $this->path = $path;
        $this->seed = $seed;
        $this->name = trim($name);


        $this->available_type = [
            "jpg",
            "jpeg",
            "png"
        ];

        $this->available_mime_type = [
            "image/jpg",
            "image/jpeg",
            "image/png"
        ];
        $this->file_size_limit = 1048576;

        $this->check();
    }

    public static function create(UploadedFile $uploaded_file, string $path, string $seed, string $name): self
    {
        return new self(
            $uploaded_file,
            $path,
            $seed,
            $name
        );
    }

    /**
     * @throws UserException
     */
    public function check(): void 
    {
        if (
            !in_array($this->uploaded_file->getClientOriginalExtension(), $this->available_type) ||
            !in_array($this->uploaded_file->getClientMimeType(), $this->available_mime_type)
            ) 
            UserException::throw("Tipe File {$this->name} Invalid", 2000);
        if ($this->uploaded_file->getSize() > 1048576)
            UserException::throw("{$this->name} Harus Dibawah 1Mb", 2000);
    }

    /**
     * @return string
     */
    public function upload(): string
    {
        $file_front = str_replace(" ", "_", strtolower($this->name));
        $encrypted_seed = base64_encode($this->seed);
        $uploaded = Storage::putFileAs(
            $this->path, 
            $this->uploaded_file, 
            $file_front."_".$encrypted_seed);
        if (!$uploaded) 
            UserException::throw("Upload {$this->name} Gagal", 2003);
        $full_path = $this->path.'/'.$file_front."_".$encrypted_seed;
        return $full_path;
    }

}
