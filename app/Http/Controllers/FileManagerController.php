<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use ZipArchive;

class FileManagerController extends Controller
{
    //


    public function index(Request $request, $busca = null)
    {
        $titulo = 'Gerenciador de Arquivos';

        $query = strtolower($request->input('busca', $busca));

        if ($query) {
            $initialDirectory = '/uploads/arquivos-transmissao';
            $initialDirectoryPath = public_path($initialDirectory);
            $filteredFiles = [];
            $filteredDirectories = [];
            $totalCount = 0;

            $this->searchFilesAndDirectories($initialDirectoryPath, $initialDirectoryPath, $query, $filteredFiles, $filteredDirectories, $totalCount);

            if ($totalCount == 1) {
                $totalItens = $totalCount . ' item encontrado';
            } elseif ($totalCount > 0) {
                $totalItens = $totalCount . ' itens encontrados';
            } else {
                $totalItens = "Nenhum item encontrado.";
            }

            return view('file-manager.busca', compact('filteredDirectories', 'filteredFiles', 'initialDirectoryPath', 'initialDirectory', 'totalItens'))->with('titulo', $titulo);
        } else {
            $fileName = null;
            $token = null;
            $caminho = $_SERVER['REQUEST_URI'];
            $pasta = basename(parse_url($caminho, PHP_URL_PATH));
            $directory = '/uploads/arquivos-transmissao/';
            $directoryPath = public_path($directory);

            if (File::isDirectory($directoryPath)) {
                $itens = scandir($directoryPath);

                /* Pastas */
                $directories = array_filter($itens, function ($item) use ($directoryPath) {
                    return is_dir($directoryPath . '/' . $item) && $item != '.' && $item != '..';
                });

                $folder = [];
                foreach ($directories as $dir) {
                    $token = Str::uuid();
                    $folder[] = [
                        'pasta' => $dir,
                        'id' => $token,
                    ];
                }
                /* Fim pastas */

                /* Arquivos */
                $files = array_filter($itens, function ($item) use ($directoryPath) {
                    return is_file($directoryPath . '/' . $item) && $item != '.DS_Store';
                });

                $data = [];
                foreach ($files as $file) {
                    $fileName = pathinfo($file, PATHINFO_FILENAME);
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $directoryPath . $file);
                    $cam = $directoryPath . '/' . $file;
                    $size = filesize($cam);

                    $datau = filemtime($cam);
                    $dataf = date('d/m/Y', $datau);

                    $kb = 1024;
                    $mb = $kb * 1024;

                    if ($size < $kb) {
                        $tamanho = $size . ' bytes';
                    } elseif ($size < $mb) {
                        $tamanho = round($size / $kb, 2) . ' Kb';
                    } else {
                        $tamanho = round($size / $mb, 2) . ' Mb';
                    }

                    $token = Str::uuid();
                    $data[] = [
                        'arquivo' => $file,
                        'id' => $token,
                        'tipo' => $mime_type,
                        'tamanho' => $tamanho,
                        'data' => $dataf,
                    ];
                }
                /* Fim arquivos */

                //unset($request['_token']);
                //$url = '/file-manager?' . http_build_query($request->all());

                return view('file-manager.index', compact('files', 'fileName', 'directory', 'directories', 'directoryPath', 'pasta', 'token', 'caminho', 'data', 'folder'))->with('titulo', $titulo);
            } else {
                return redirect('/file-manager')->with('error', 'O diretório não existe.');
            }
        }
    }

    private function searchFilesAndDirectories($directory, $baseDirectory, $query, &$filteredFiles, &$filteredDirectories, &$totalCount)
    {
        $items = scandir($directory);

        foreach ($items as $item) {
            if ($item != "." && $item != "..") {
                $itemPath = $directory . '/' . $item;
                $itemName = strtolower($item);

                if (is_file($itemPath) && $item != '.DS_Store') {
                    if (strpos($itemName, $query) !== false) {
                        $size = filesize($itemPath);
                        $datau = filemtime($itemPath);
                        $dataf = date('d/m/Y', $datau);
                        $kb = 1024;
                        $mb = $kb * 1024;

                        if ($size < $kb) {
                            $tamanho = $size . ' bytes';
                        } elseif ($size < $mb) {
                            $tamanho = round($size / $kb, 2) . ' Kb';
                        } else {
                            $tamanho = round($size / $mb, 2) . ' Mb';
                        }

                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime_type = finfo_file($finfo, $itemPath);
                        finfo_close($finfo);

                        $relativePath = trim(str_replace($baseDirectory, '', $itemPath), '');
                        $relativePath = dirname($relativePath);

                        $filteredFiles[] = [
                            'arquivo' => $item,
                            'caminho' => $relativePath,
                            'tipo' => $mime_type,
                            'tamanho' => $tamanho,
                            'data' => $dataf,
                            'id' => Str::uuid(),
                        ];

                        $totalCount++;
                    }
                } elseif (is_dir($itemPath)) {
                    if (strpos($itemName, $query) !== false) {
                        $datau = filemtime($itemPath);
                        $dataf = date('d/m/Y', $datau);

                        $relativePath = trim(str_replace($baseDirectory, '', $itemPath), '');
                        $relativePath = dirname($relativePath);

                        $filteredDirectories[] = [
                            'pasta' => $item,
                            'caminho' => $relativePath,
                            'data' => $dataf,
                            'id' => Str::uuid(),
                        ];

                        $totalCount++;
                    }

                    $this->searchFilesAndDirectories($itemPath, $baseDirectory, $query, $filteredFiles, $filteredDirectories, $totalCount);
                }
            }
        }
    }

    public function updates()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $updates = $this->getUpdatesFromSomewhere(); // Função para obter as atualizações

        foreach ($updates as $update) {
            echo "data: $update\n\n";
            ob_flush();
            flush();
            usleep(1000000); // Aguarda 1 segundo antes de enviar a próxima atualização
        }
    }

    public function create(Request $request)
    {
        $remover = $request->header('Origin').'/file-manager';
        $caminho = $_SERVER['REQUEST_URI'];
        $path = $request->url;
        $pasta = str_replace($remover, "", $path);


        $directory = public_path().'/uploads/arquivos-transmissao/'.$pasta;
        //$directory = public_path().'/uploads/arquivos-transmissao/';

        /* echo $pasta;
        die(); */

        // Verifique se o formulário foi enviado para criar uma nova pasta
        if ($request->has('folder_name')) {
            $folderName = $request->input('folder_name');
            $newFolder = $directory . '/' . $folderName;

            /* echo $newFolder;
            die(); */

            // Certifique-se de que a pasta ainda não existe antes de criar
            if (!File::exists($newFolder)) {
                // Tenta criar o diretório com permissões 0755
                $success = File::makeDirectory($newFolder, 0777, true, true);

                /* DB::table('file_manager')->insert([
                    'path' => $folderName
                ]); */

                if (!$success) {
                    // Se a criação falhar, redirecione com uma mensagem de erro
                    return redirect('/file-manager')->with('error', 'Erro ao criar a pasta. Verifique as permissões.');

                }
            }
        }

        // Redirecione de volta à página do gerenciador de arquivos após a criação da pasta
        return redirect()->back()->with('success', 'Pasta criada com sucesso.');
        //return redirect("/file-manager/$folderName")->with('success', 'Pasta criada com sucesso.');
    }

    public function show()
    {
        $titulo = 'Gerenciador de Arquivos';
        $fileName = null;
        $token = null;
        $caminho = $_SERVER['REQUEST_URI'];
        $pasta = basename(parse_url($caminho, PHP_URL_PATH));
        $directory = '/uploads/arquivos-transmissao/';//.$pasta;

        /* Breadcrumbs */
        $remover = "/file-manager/";
        $urlModificada = str_replace($remover, "", $caminho);
        $segments = $urlModificada ? explode('/', $urlModificada) : [];

        $breadcrumb = [];
        $currentPath = '';
        foreach ($segments as $segment) {
            $currentPath .= $segment . '/';
            $breadcrumb[] = [
                'name' => $segment,
                'url' => url('/file-manager/' . rtrim($currentPath, '/')),
            ];
        }
        /* Fim Breadcrumbs */

        $directoryPath = public_path($directory).$urlModificada;
        $showdir = $directory.$urlModificada.'/';



        // Verifique se o diretório existe
        if (File::isDirectory($directoryPath)) {
            // Obtenha detalhes dos arquivos no diretório
            $f = File::allFiles($directoryPath);
            $itens = scandir($directoryPath);
           /* Pastas */
           $directories = array_filter($itens, function($item) use ($directoryPath) {
                return is_dir($directoryPath . '/' . $item) && $item != '.' && $item != '..';
            });
            $folder = [];
                foreach ($directories as $dir) {
                    $token = Str::uuid(); // Use o UUID como exemplo, você pode escolher outro método
                    // Adiciona ao array associativo
                    $folder[] = [
                        'pasta' => $dir,
                        'id' => $token,
                    ];
                }
            /* Fim pastas */

            /* Arquivos */
            $files = array_filter($itens, function($items) use ($directoryPath) {
                return is_file($directoryPath . '/' . $items) && $items != '.DS_Store';
            });
            $data = [];
                foreach ($files as $file) {
                    // Obtém o nome do arquivo
                    $fileName = pathinfo($file, PATHINFO_FILENAME);
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $directoryPath.'/'.$file);
                    $cam = $directoryPath.'/'.$file;
                    $size = filesize($cam);

                    $datau = filemtime($cam);
                    $dataf = date('d/m/Y', $datau);

                    $kb = 1024;
                    $mb = $kb * 1024;

                    if($size < $kb){
                        $tamanho = $size . ' bytes';
                    }  elseif ($size < $mb) {
                        $tamanho =  round($size / $kb, 2) . ' Kb';
                    }  else {
                        $tamanho =  round($size / $mb, 2) . ' Mb';
                    }

                    // Gera um hash único baseado no nome do arquivo
                    $token = Str::uuid(); // Use o UUID como exemplo, você pode escolher outro método
                    // Adiciona ao array associativo
                    $data[] = [
                        'arquivo' => $file,
                        'id' => $token,
                        'tipo' => $mime_type,
                        'tamanho' => $tamanho,
                        'data' => $dataf,
                    ];
                }

            /* Fim arquivos */

            return view('file-manager.show', compact('files', 'directory','directories','directoryPath', 'pasta','breadcrumb','token', 'data', 'fileName', 'folder', 'showdir'))->with('titulo', $titulo);;
        } else {
            return redirect('/file-manager')->with('error', 'O diretório não existe.');
        }
    }

    public function upload(Request $request, $path = null)
    {
        $caminho = $_SERVER['REQUEST_URI'];
        $path = $request->url;
        $remover = $request->header('Origin').'/file-manager';
        $pasta = str_replace($remover, "", $path);

        $urlPaginaAnterior = URL::previous();

        //return redirect($fullPath)->with('success', 'Arquivo(s) enviado(s) com sucesso.');
        if ($pasta == 'file-manager') {
            $directory = public_path().'/uploads/arquivos-transmissao';
        } else {
            $directory = public_path().'/uploads/arquivos-transmissao'.$pasta;
        }

        $request->validate([
            'arquivo.*' => 'required|mimes:zip,webp,jpg,jpeg,png,pdf,xml,xlsx,xls,txt,doc,docx,ppt,pptx,mp3,mpeg,mkv,mp4,mov|max:20000000', // Adapte os tipos de arquivo conforme necessário
        ]);



        foreach ($request->file('arquivo') as $file) {
            if ($file->isValid()) {

                $arquivos = $file->getClientOriginalName();
                $file->move($directory, $arquivos);

            } else {
                return redirect()->back()->with('error', 'Erro no upload de arquivos: ' . $file->getErrorMessage());
            }
        }
        //return redirect()->back()->with('success', 'Arquivo(s) enviado(s) com sucesso.');
        return redirect()->route('file-manager.index', ['busca' => $request->input('busca')]);
    }

    public function excluirArquivo(Request $request)
    {
        $arquivo = $request->caminho;

        // Realize a lógica de exclusão aqui
        if (File::exists($arquivo)) {
            File::delete($arquivo);
            return redirect()->back()->with('success', 'Arquivo excluiudo com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Não foi possível excluir o(s) Arquivo(s)');
        }
    }

    public function delDir(Request $request)
    {
        $arquivo = $request->caminho;

        // Realize a lógica de exclusão aqui
        if ($arquivo) {
            File::deleteDirectory($arquivo);
            return redirect()->back()->with('success', 'Pasta excluída com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Não foi possível excluir a pasta');
        }
    }

    public function rename(Request $request, string $id){

        $caminho = $_SERVER['REQUEST_URI'];
        $path = $request->url;
        $remover = $request->header('Origin').'/file-manager';
        $pasta = str_replace($remover, "", $path);

        $novoNome = $request['nova_pasta'];

        if ($pasta == 'file-manager') {
            $diretorioOriginal = public_path().'/uploads/arquivos-transmissao/'.$request['pasta_antiga'];
            $novoCaminho = public_path().'/uploads/arquivos-transmissao/'.$novoNome;
        } else {
            $diretorioOriginal = public_path().'/uploads/arquivos-transmissao'.$pasta.'/'.$request['pasta_antiga'];
            $novoCaminho = public_path().'/uploads/arquivos-transmissao'.$pasta.'/'.$novoNome;
        }

        // Verifica se o diretório original existe
        if (is_dir($diretorioOriginal)) {
            // Verifica se o novo nome não está sendo usado
            if (!is_dir($novoCaminho)) {
                // Renomeia a pasta
                if (rename($diretorioOriginal, $novoCaminho)) {
                    return redirect()->back()->with('success', 'Pasta renomeada com sucesso.');
                } else {
                    return redirect()->back()->with('error', 'Erro ao renoemar a pasta');
                }
            } else {
                return redirect()->back()->with('error', 'Já existe um diretório com este nome. Escolha um novo nome.');
            }
        } else {
            return redirect()->back()->with('error', 'O diretório original não existe.');
        }

    }

    public function renameFile(Request $request, string $id)
    {

        $caminho = $_SERVER['REQUEST_URI'];

        $path = $request->url;
        $remover = $request->header('Origin').'/file-manager';
        $pasta = str_replace($remover, "", $path);

        $arquivo_antigo = $request['arquivo_antigo'];
        $arquivo_novo = $request['arquivo_novo'];



        if ($pasta == 'file-manager') {
            $diretorioOriginal = public_path().'/uploads/arquivos-transmissao/'.$arquivo_antigo;
            $novoCaminho = public_path().'/uploads/arquivos-transmissao/'.$arquivo_novo;
        } else {
            $diretorioOriginal = public_path().'/uploads/arquivos-transmissao'.$pasta.'/'.$arquivo_antigo;
            $novoCaminho = public_path().'/uploads/arquivos-transmissao'.$pasta.'/'.$arquivo_novo;
        }

        // Realize a lógica de exclusão aqui
        if (File::exists($diretorioOriginal)) {
            if (rename($diretorioOriginal, $novoCaminho)) {
                return redirect()->back()->with('success', 'Arquivo renomeado com sucesso.');
            } else {
                return redirect()->back()->with('error', 'Erro ao renoemar o arquivo');
            }
        }
    }

    public function zipFile(Request $request, string $id)
    {
        // Diretório que você deseja compactar


        $folder = $request->folder;

        $caminho = $request->server('HTTP_REFERER');
        $scheme  = $request->server('REQUEST_SCHEME');
        $path = URL::previous();
        // Analisar a URL para obter o componente de consulta
        $queryString = parse_url($path, PHP_URL_QUERY);
        parse_str($queryString, $params);
        $termoDeBusca = $params['busca'];

        $remover = $scheme.'://'.$request->server('HTTP_HOST').'/file-manager';
        $pasta = str_replace($remover, "", $path);

        if ($pasta == 'file-manager' || $pasta == '?busca='.$termoDeBusca) {
            $directoryToZip = public_path().'/uploads/arquivos-transmissao/'.$folder;
        } else {
            $directoryToZip = public_path().'/uploads/arquivos-transmissao'.$pasta.'/'.$folder;
        }

        // Nome do arquivo zip a ser gerado
        $zipFileName = $id.'.zip';

        // Caminho completo para o arquivo zip
        $zipFilePath = $directoryToZip.$zipFileName;



        // Cria um novo objeto ZipArchive
        $zip = new ZipArchive();

        // Abre o arquivo zip para escrita
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Adiciona os arquivos do diretório ao arquivo zip
            $files = File::allFiles($directoryToZip);
            foreach ($files as $file) {
                // Adiciona o arquivo ao zip, usando o nome relativo ao diretório base
                $relativePath = substr($file->getPathname(), strlen($directoryToZip));
                $zip->addFile($file->getPathname(), $relativePath);
            }

            // Fecha o arquivo zip
            try {
                $zip->close();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'A pasta não contém arquivos e não pode ser compactada');
            }


            // Inicia o download do arquivo zip
            return response()->download($zipFilePath)->deleteFileAfterSend();
        }

        // Se houver algum problema, redirecione ou retorne uma resposta adequada
        return redirect()->back()->with('error', 'Falha ao criar arquivo zip.');
    }

}
