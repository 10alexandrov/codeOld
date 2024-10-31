<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Models\ConfigMC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConfigurationController extends Controller
{
    // Definición de las variables globales
    private $cryptString_encrypt_method = "AES-256-CBC";
    private $cryptString_secret_key = 's3cr3t0929387k3y';
    private $cryptString_key;
    private $cryptString_secret_iv = 'magic924172970iv';
    private $cryptString_iv;

    public function __construct()
    {
        $this->cryptString_key = hash('sha256', $this->cryptString_secret_key);
        $this->cryptString_iv = substr(hash('sha256', $this->cryptString_secret_iv), 0, 16);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //dd($id);
        // Obtener la configuración encriptada
        $auxlocalConfig = ConfigMC::where('local_id', $id)->first();
        $s = $auxlocalConfig->local;
        //dd($s->name);

        if (!$auxlocalConfig) {
            abort(404, 'Configuración no encontrada');
        }

        // Crear un array para almacenar los datos desencriptados temporalmente
        $localConfigJson = [];

        // Desencriptar los atributos necesarios solo para mostrar en el formulario
        foreach ($auxlocalConfig->getAttributes() as $key => $value) {
            // Si el valor comienza con "CryptSTR2352-", lo desencriptamos
            if (Str::startsWith($value, "CryptSTR2352-")) {
                $decryptedValue = $this->decryptString($value); // Desencriptar el valor completo
                $localConfigJson[$key] = $decryptedValue;
            } else {
                $localConfigJson[$key] = $value; // Mantener valores no encriptados
            }
        }

        // Convertir el array a JSON
        $decodedConfig = json_encode($localConfigJson);

        // Decodificar el JSON de vuelta a un objeto PHP para manipulación en la vista
        $localConfig = json_decode($decodedConfig);

        //$name = $auxlocalConfig->local->name;
        //dd($auxlocalConfig->local_id->name);
        // Devolver la vista con los datos desencriptados
        return view('configuration.show', compact('localConfig', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $localConfig = ConfigMC::find($id);

        if (!$localConfig) {
            abort(404, 'Configuración no encontrada');
        }

        // Aquí puedes usar el método decryptString si necesitas desencriptar algún campo específico

        return view('configuration.edit', compact('localConfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(ConfigRequest $request, $id)
    {

        dd($request->all());
        // Validar y procesar la solicitud
        $validatedData = $request->validated();

        // Buscar la configuración local por ID
        $localConfig = ConfigMC::where('local_id', $id)->first();

        if (!$localConfig) {
            abort(404, 'Configuración no encontrada');
        }

        // Procesar los checkboxes para los campos OnCloseTicketTypeIPCreationX
        $localConfig->OnCloseTicketTypeIPCreation1 = $request->has('OnCloseTicketTypeIPCreation1');
        $localConfig->OnCloseTicketTypeIPCreation2 = $request->has('OnCloseTicketTypeIPCreation2');
        $localConfig->OnCloseTicketTypeIPCreation3 = $request->has('OnCloseTicketTypeIPCreation3');
        $localConfig->OnCloseTicketTypeIPCreation4 = $request->has('OnCloseTicketTypeIPCreation4');
        $localConfig->OnCloseTicketTypeIPCreation5 = $request->has('OnCloseTicketTypeIPCreation5');

        // Otros campos que necesitan actualización
        $localConfig->MoneySymbol = $validatedData['MoneySymbol'];
        $localConfig->MoneyLowLimitToCreate = $validatedData['MoneyLowLimitToCreate'];
        $localConfig->MoneyLimitThatNeedsAuthorization = $validatedData['MoneyLimitThatNeedsAuthorization'];
        // Agregar aquí todos los demás campos que necesiten actualización

        // Asegurar que HeaderOfTicketNumber tenga un valor predeterminado si es nulo
        if (is_null($localConfig->HeaderOfTicketNumber)) {
            $localConfig->HeaderOfTicketNumber = ' ';
        }

        // Guardar los cambios en la base de datos
        $localConfig->save();

        // Redirigir a la página deseada con un mensaje de éxito
        return redirect()->route('locals.show', $id)->with('success', 'Configuración actualizada correctamente.');
    }*/
    public function update(ConfigRequest $request, $id)
    {
        // Validar y procesar la solicitud
        $validatedData = $request->validated();

        // Convertir campos checkbox nulos a 0
        $checkboxFields = [
            'MoneyAdaptLowValuesOnCreation',
            'MoneyLimitInTypeBets',
            'RoundPartialPrizes',
            'NewTicketNumberFormat',
            'AdvancedGUI',
            'ForceAllowExports',
            'TITOExpirationType',
            'AutoAddIPsToBan',
            'AutoAddMACsToBan',
            'OnCloseTicketTypeIPCreation1',
            'OnCloseTicketTypeIPCreation2',
            'OnCloseTicketTypeIPCreation3',
            'OnCloseTicketTypeIPCreation4',
            'OnCloseTicketTypeIPCreation5',
        ];

        foreach ($checkboxFields as $field) {
            if (!isset($validatedData[$field])) {
                $validatedData[$field] = 0;
            }
        }

        // Buscar la configuración local por ID
        $localConfig = ConfigMC::where('local_id', $id)->firstOrFail();

        // Asignar valores validados al modelo ConfigMC
        $localConfig->fill($validatedData);

        // Campos sensibles que necesitan encriptación
        $fieldsToEncrypt = [
            'AllowIPs',
            'BanIPs',
            'AllowMACs',
            'BanMACs',
            'AllowTicketTypes',
            'BanTicketTypes',
            'OnCloseTicketTypeFilter1',
            'OnCloseTicketTypeAllowIPs1',
            'OnCloseTicketTypeBanIPs1',
            'OnCloseTicketTypeFilter2',
            'OnCloseTicketTypeAllowIPs2',
            'OnCloseTicketTypeBanIPs2',
            'OnCloseTicketTypeFilter3',
            'OnCloseTicketTypeAllowIPs3',
            'OnCloseTicketTypeBanIPs3',
            'OnCloseTicketTypeFilter4',
            'OnCloseTicketTypeAllowIPs4',
            'OnCloseTicketTypeBanIPs4',
            'OnCloseTicketTypeFilter5',
            'OnCloseTicketTypeAllowIPs5',
            'OnCloseTicketTypeBanIPs5',
        ];

        // Asignar el valor por defecto a ExpirationDate
        $localConfig->ExpirationDate = '0000-00-00 00:00:00';

        foreach ($fieldsToEncrypt as $field) {
            if (empty($localConfig->$field)) {
                $localConfig->$field = $this->encryptString(' ');
            } else {
                $localConfig->$field = $this->encryptString($localConfig->$field);
            }
        }

        // Asegurar que HeaderOfTicketNumber tenga un valor predeterminado si es nulo
        if (is_null($localConfig->HeaderOfTicketNumber)) {
            $localConfig->HeaderOfTicketNumber = ' ';
        }
        //dd($validatedData);
        //dd($localConfig);

        // Convertir el modelo a un array
        $configArray = $localConfig->toArray();
        dd($configArray);
        // Eliminar el campo 'local_id' del array
        unset($configArray['local_id']);
        unset($configArray['created_at']);
        unset($configArray['updated_at']);

        //
        //$updateConfig = DB::connection(nuevaConexion($id))->table('config')->update($configArray);
        //dd($updateConfig);


        //dd();

        // Guardar los cambios en mi base de datos local
        // pero hay que grabarlo en el servidor y luego ejecutar el SCRIPT para que me traiga los datos a mi BD local
        //$localConfig->save();

        // Redirigir a la página deseada con un mensaje de éxito
        return redirect()->route('locals.show', $id)->with('success', 'Configuración actualizada correctamente.');
    }
    /**
     * Función para encriptar una cadena.
     */
    private function encryptString($string)
    {
        if ($this->startsWith($string, "CryptSTR2352-")) return $string;

        $output = openssl_encrypt($string, $this->cryptString_encrypt_method, $this->cryptString_key, 0, $this->cryptString_iv);
        $output = base64_encode($output);

        if ($output !== false) {
            return "CryptSTR2352-" . $output;
        }
        return $string;
    }

    /**
     * Función para descifrar una cadena.
     */
    private function decryptString($string)
    {
        if (!$this->startsWith($string, "CryptSTR2352-")) {
            return $string;
        }

        $string = str_replace("CryptSTR2352-", "", $string);
        if (!empty($string)) {
            $output = base64_decode($string);
            $output = openssl_decrypt($output, $this->cryptString_encrypt_method, $this->cryptString_key, 0, $this->cryptString_iv);
            return $output;
        }

        return $string;
    }

    /**
     * Función para verificar si una cadena comienza con cierto prefijo.
     */
    private function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
}
