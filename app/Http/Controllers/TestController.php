<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TestController extends Controller
{
    // Laravel Welcome Page and Python version check
    public function welcome()
    {
        // Python path
        $python_path = env('PYTHON_PATH');
        // Python version check
        $script_path = base_path('resources/python/test.py');

        $process = new Process([$python_path, $script_path]);
        $process->run();

        // プロセスの実行に失敗した場合、例外を投げる
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // スクリプトの出力を取得
        $output = $process->getOutput();

        return view('welcome', ['python_ver' => $output]);
    }
}
