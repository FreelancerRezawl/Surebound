<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SetupController extends Controller
{
    /**
     * Check if application is already installed
     */
    private function isInstalled()
    {
        return File::exists(storage_path('installed'));
    }

    public function welcome()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $requirements = [
            'PHP >= 8.1' => version_compare(PHP_VERSION, '8.1.0', '>='),
            'BCMath PHP Extension' => extension_loaded('bcmath'),
            'Ctype PHP Extension' => extension_loaded('ctype'),
            'JSON PHP Extension' => extension_loaded('json'),
            'Mbstring PHP Extension' => extension_loaded('mbstring'),
            'OpenSSL PHP Extension' => extension_loaded('openssl'),
            'PDO PHP Extension' => extension_loaded('pdo'),
            'Tokenizer PHP Extension' => extension_loaded('tokenizer'),
            'XML PHP Extension' => extension_loaded('xml'),
            '.env Writable' => File::isWritable(base_path('.env')),
            'storage Writable' => File::isWritable(storage_path()),
        ];

        $allRequirementsPassed = ! in_array(false, $requirements);

        return view('setup', [
            'step' => 1,
            'requirements' => $requirements,
            'allRequirementsPassed' => $allRequirementsPassed,
        ]);
    }

    public function database()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('setup', ['step' => 2]);
    }

    public function saveDatabase(Request $request)
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $request->validate([
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
        ]);

        try {
            // Test connection first dynamically
            config([
                'database.connections.mysql.host' => $request->db_host,
                'database.connections.mysql.port' => $request->db_port,
                'database.connections.mysql.database' => $request->db_database,
                'database.connections.mysql.username' => $request->db_username,
                'database.connections.mysql.password' => $request->db_password,
            ]);
            DB::purge('mysql');
            DB::connection()->getPdo();

            // Connection successful, write to .env
            $this->setEnvironmentValue([
                'DB_HOST' => $request->db_host,
                'DB_PORT' => $request->db_port,
                'DB_DATABASE' => $request->db_database,
                'DB_USERNAME' => $request->db_username,
                'DB_PASSWORD' => $request->db_password ? '"'.$request->db_password.'"' : '',
            ]);

            return redirect()->route('setup.migrations');

        } catch (\Exception $e) {
            return back()->with('error', 'Could not connect to the database. Please check your credentials. Error: '.$e->getMessage());
        }
    }

    public function migrations()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('setup', ['step' => 3]);
    }

    public function runMigrations()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        try {
            Artisan::call('migrate:fresh', ['--force' => true]);
            // If you have seeders, you can run them here:
            // Artisan::call('db:seed', ['--force' => true]);

            return redirect()->route('setup.admin');
        } catch (\Exception $e) {
            return back()->with('error', 'Migration failed: '.$e->getMessage());
        }
    }

    public function admin()
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        return view('setup', ['step' => 4]);
    }

    public function saveAdmin(Request $request)
    {
        if ($this->isInstalled()) {
            return redirect('/');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
            ]);

            // Mark as installed
            File::put(storage_path('installed'), 'Installed on '.now());

            return redirect()->route('setup.complete');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create admin user: '.$e->getMessage());
        }
    }

    public function complete()
    {
        if (! $this->isInstalled()) {
            return redirect()->route('setup.welcome');
        }

        return view('setup', ['step' => 5]);
    }

    private function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        foreach ($values as $envKey => $envValue) {
            $keyPosition = strpos($str, "{$envKey}=");
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

            // If key does not exist, append it
            if (! $keyPosition || ! $endOfLinePosition || ! $oldLine) {
                $str .= "{$envKey}={$envValue}\n";
            } else {
                $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
            }
        }

        $str = substr($str, 0, -1);
        file_put_contents($envFile, $str);
    }
}
