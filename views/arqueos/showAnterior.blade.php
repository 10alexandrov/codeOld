<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Parte con la que trabaja el STORE de las cargas auxiliares

        // Asociar eventos de clic a los botones
        document.getElementById('add-machine-btn').addEventListener('click', addMachineRow);
        document.getElementById('remove-machine-btn').addEventListener('click', deleteRecarga);

        // Asociar eventos de input a los campos de la tabla
        const tableBody = document.querySelector('#contabilidad-table tbody');
        tableBody.addEventListener('input', function(event) {
            if (event.target.matches(
                    'input[name="coin1[]"], input[name="coin10[]"], input[name="coin20[]"], input[name="coin50[]"], input[name="carga1[]"], input[name="carga10[]"], input[name="carga20[]"], input[name="carga50[]"]'
                )) {
                actualizarTotal();
            }
        });

        // Función para clonar la fila de máquina y agregarla a la tabla
        function addMachineRow() {
            var table = document.getElementById('contabilidad-table').getElementsByTagName('tbody')[0];
            var lastRow = table.rows[table.rows.length - 1];
            var newRow = lastRow.cloneNode(true);

            // Obtener el número actual de máquinas
            var currentMachineNumber = table.rows.length;

            // Limpiar los valores de los inputs clonados y establecer nuevos IDs y nombres
            var inputs = newRow.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = ''; // Limpiar el valor
                inputs[i].disabled = false; // Habilitar el input
                if (inputs[i].type !== 'date' && inputs[i].type !== 'text') {
                    inputs[i].value = '0';
                }
                var name = inputs[i].name;
                if (name) {
                    inputs[i].name = name.replace(/\[\d+\]/, '[' + currentMachineNumber + ']');
                    if (inputs[i].id) {
                        inputs[i].id = inputs[i].id.replace(/-\d+$/, '-' + currentMachineNumber);
                    }
                }
            }

            // Habilitar todos los selects del formulario
            var selects = newRow.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                selects[i].disabled = false;
            }

            // Deshabilitar y establecer valor por defecto en el campo de total para la nueva fila
            var newTotalInput = newRow.querySelector('.total-input');
            newTotalInput.disabled = true; // Total debe ser de solo lectura
            newTotalInput.value = '0€';

            // Añadir la nueva fila a la tabla
            table.appendChild(newRow);

            // Actualizar ID del select para evitar duplicados
            var newSelect = newRow.querySelector('select');
            newSelect.id = 'maquina-' + currentMachineNumber;

            comprobarchilds();
            actualizarTotal(); // Llamar para actualizar los totales después de agregar la fila
        }

        // Función para eliminar la última fila de la tabla
        function deleteRecarga() {
            var table = document.getElementById('contabilidad-table').getElementsByTagName('tbody')[0];
            // Solo eliminar si hay más de una fila
            if (table.rows.length > 1) {
                table.deleteRow(-1); // Eliminar la última fila
                comprobarchilds();
                actualizarTotal(); // Llamar para actualizar los totales después de eliminar la fila
            } else {
                alert("Debe haber al menos una fila en la tabla.");
            }
        }

        function comprobarchilds() {
            var table = document.getElementById('contabilidad-table').getElementsByTagName('tbody')[0];
            const deleteBtn = document.getElementById('remove-machine-btn');

            if (table.rows.length > 1) {
                deleteBtn.disabled = false;
            } else {
                deleteBtn.disabled = true;
            }
        }

        // Evento que se dispara cuando se abre el modal
        document.querySelector('#secureModalInsert').addEventListener('show.bs.modal', function() {
            console.log('Modal abierto');
            clearInsertModal(); // Llama a la función para limpiar el modal de inserción
            updateSummaryTable(); // Llama a la función para actualizar la tabla de resumen
        });

        // Función para limpiar el modal de inserción
        function clearInsertModal() {
            const summaryTableBody = document.querySelector('#summary-table tbody');
            summaryTableBody.innerHTML = ''; // Limpiar la tabla de resumen

            // Limpiar campos ocultos
            document.getElementById('hidden-maquinas').value = '';
            document.getElementById('hidden-coin1').value = '';
            document.getElementById('hidden-coin10').value = '';
            document.getElementById('hidden-coin20').value = '';
            document.getElementById('hidden-coin50').value = '';
            document.getElementById('hidden-carga1').value = '';
            document.getElementById('hidden-carga10').value = '';
            document.getElementById('hidden-carga20').value = '';
            document.getElementById('hidden-carga50').value = '';
            document.getElementById('hidden-total').value = '';
        }

        function updateSummaryTable() {
            console.log('Actualizando la tabla de resumen');
            const summaryTableBody = document.querySelector('#summary-table tbody');
            const rows = document.querySelectorAll('#contabilidad-table tbody tr');

            // Limpiar el contenido previo de la tabla de resumen
            summaryTableBody.innerHTML = '';

            // Arrays para almacenar los valores de los inputs
            let maquinas = [];
            let coin1Arr = [];
            let coin10Arr = [];
            let coin20Arr = [];
            let coin50Arr = [];
            let carga1Arr = [];
            let carga10Arr = [];
            let carga20Arr = [];
            let carga50Arr = [];
            let totalArr = [];

            rows.forEach(row => {
                // Asegúrate de que la fila no esté en modo de edición
                if (row !== currentEditingRow) {
                    // Obtener el valor de la máquina desde el select
                    const selectElement = row.querySelector('select[name="maquina[]"]');
                    const machineValue = selectElement ? selectElement.options[selectElement
                        .selectedIndex]?.value : '';
                    const machineName = selectElement ? selectElement.options[selectElement
                        .selectedIndex]?.text : '';

                    // Obtener los valores de cada input, asegurándonos de que no sean nulos
                    const coin1 = row.querySelector('input[name="coin1[]"]')?.value || '0';
                    const coin10 = row.querySelector('input[name="coin10[]"]')?.value || '0';
                    const coin20 = row.querySelector('input[name="coin20[]"]')?.value || '0';
                    const coin50 = row.querySelector('input[name="coin50[]"]')?.value || '0';
                    const carga1 = row.querySelector('input[name="carga1[]"]')?.value || '0';
                    const carga10 = row.querySelector('input[name="carga10[]"]')?.value || '0';
                    const carga20 = row.querySelector('input[name="carga20[]"]')?.value || '0';
                    const carga50 = row.querySelector('input[name="carga50[]"]')?.value || '0';
                    const total = row.querySelector('.total-input')?.value.replace('€', '') || '0';

                    console.log(
                        `Fila - Máquina: ${machineValue}, 1€: ${coin1}, 10€: ${coin10}, 20€: ${coin20}, 50€: ${coin50}, Carga 1€: ${carga1}, Carga 10€: ${carga10}, Carga 20€: ${carga20}, Carga 50€: ${carga50}, Total: ${total}`
                    );

                    // Validar que solo se agregue una fila si hay datos presentes
                    if (machineValue.trim() || coin1 !== '0' || coin10 !== '0' || coin20 !== '0' ||
                        coin50 !== '0' || carga1 !== '0' || carga10 !== '0' || carga20 !== '0' ||
                        carga50 !== '0' || total !== '0') {
                        // Añadir los valores a los arrays
                        maquinas.push(machineValue);
                        coin1Arr.push(coin1);
                        coin10Arr.push(coin10);
                        coin20Arr.push(coin20);
                        coin50Arr.push(coin50);
                        carga1Arr.push(carga1);
                        carga10Arr.push(carga10);
                        carga20Arr.push(carga20);
                        carga50Arr.push(carga50);
                        totalArr.push(total);

                        // Crear una nueva fila para la tabla de resumen
                        const newRow = `
                    <tr>
                        <td>${machineName}</td>
                        <td>${coin1}</td>
                        <td>${coin10}</td>
                        <td>${coin20}</td>
                        <td>${coin50}</td>
                        <td>${carga1}</td>
                        <td>${carga10}</td>
                        <td>${carga20}</td>
                        <td>${carga50}</td>
                        <td>${total}</td>
                    </tr>
                `;
                        summaryTableBody.insertAdjacentHTML('beforeend', newRow);
                    }
                }
            });

            // Pasar los valores a los campos ocultos del modal
            document.getElementById('hidden-maquinas').value = JSON.stringify(maquinas);
            document.getElementById('hidden-coin1').value = JSON.stringify(coin1Arr);
            document.getElementById('hidden-coin10').value = JSON.stringify(coin10Arr);
            document.getElementById('hidden-coin20').value = JSON.stringify(coin20Arr);
            document.getElementById('hidden-coin50').value = JSON.stringify(coin50Arr);
            document.getElementById('hidden-carga1').value = JSON.stringify(carga1Arr);
            document.getElementById('hidden-carga10').value = JSON.stringify(carga10Arr);
            document.getElementById('hidden-carga20').value = JSON.stringify(carga20Arr);
            document.getElementById('hidden-carga50').value = JSON.stringify(carga50Arr);
            document.getElementById('hidden-total').value = JSON.stringify(totalArr);

            console.log("Campos ocultos actualizados:", {
                maquinas,
                coin1Arr,
                coin10Arr,
                coin20Arr,
                coin50Arr,
                carga1Arr,
                carga10Arr,
                carga20Arr,
                carga50Arr,
                totalArr
            });
        }


        // Evento para validar y enviar el formulario desde el modal
        document.getElementById('submitBtnRecarga').addEventListener('click', function(event) {
            console.log('Botón de guardar clickeado');
            updateSummaryTable(); // Asegúrate de que la tabla se actualice antes de enviar
            // Envía el formulario
            document.querySelector('#recarga-form').submit();
        });

        // Función para actualizar el total de cada fila
        function actualizarTotal() {
            var rows = document.querySelectorAll('#contabilidad-table tbody tr');
            rows.forEach(function(row) {
                var coin1 = parseInt(row.querySelector('input[name="coin1[]"]').value) || 0;
                var coin10 = parseInt(row.querySelector('input[name="coin10[]"]').value) || 0;
                var coin20 = parseInt(row.querySelector('input[name="coin20[]"]').value) || 0;
                var coin50 = parseInt(row.querySelector('input[name="coin50[]"]').value) || 0;
                var carga1 = parseInt(row.querySelector('input[name="carga1[]"]').value) || 0;
                var carga10 = parseInt(row.querySelector('input[name="carga10[]"]').value) || 0;
                var carga20 = parseInt(row.querySelector('input[name="carga20[]"]').value) || 0;
                var carga50 = parseInt(row.querySelector('input[name="carga50[]"]').value) || 0;

                var total = coin1 * 1 + coin10 * 10 + coin20 * 20 + coin50 * 50 + carga1 * 1 + carga10 *
                    10 + carga20 * 20 + carga50 * 50;

                var totalInput = row.querySelector('.total-input');
                if (totalInput) {
                    totalInput.disabled = true; // El campo total es de solo lectura
                    totalInput.value = total + '€';
                }
            });
        }

        // Parte con la que trabaja el EDITAR de las cargas auxiliares
        let currentEditingRow = null; // Mantener el seguimiento de la fila actualmente en edición
        let
            originalValues = {}; // para meter los valores de la linea a la hora de editarlos, para poder mostrarlos cuando usemos el boton cancelar

        function addInputListeners(row) {
            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    updateHiddenFields(row);
                });
            });
        }

        // Llamar a esta función cuando habilites la edición
        function enableEdit(rowId) {
            console.log('enableEdit fue llamada con rowId:',
                rowId); // Comprobar si enableEdit se está llamando correctamente

            const row = document.getElementById(rowId);
            console.log('Elemento fila encontrado:', row); // Verificar si la fila fue encontrada

            if (!row) {
                console.error(`Fila con ID ${rowId} no encontrada.`);
                return;
            }

            if (currentEditingRow && currentEditingRow !== row) {
                cancelEdit(currentEditingRow);
            }

            // Almacenar los valores originales
            originalValues = {
                value1: row.querySelector('.value1-input').value,
                value10: row.querySelector('.value10-input').value,
                value20: row.querySelector('.value20-input').value,
                value50: row.querySelector('.value50-input').value,
                carga1: row.querySelector('.carga1-input').value,
                carga10: row.querySelector('.carga10-input').value,
                carga20: row.querySelector('.carga20-input').value,
                carga50: row.querySelector('.carga50-input').value,
                total: row.querySelector('.total-cell').textContent
            };

            // Verificar si los inputs y botones existen en la fila antes de modificarlos
            const inputs = row.querySelectorAll('input');
            console.log('Inputs en la fila:', inputs); // Log de los inputs encontrados

            inputs.forEach(input => {
                if (input) {
                    input.removeAttribute('disabled');
                } else {
                    console.error('Input no encontrado.');
                }
            });

            const machineSpan = row.querySelector('.machine-name');
            const machineSelect = row.querySelector('.machine-select');

            console.log('machineSpan:', machineSpan);
            console.log('machineSelect:', machineSelect);

            if (machineSpan && machineSelect) {
                machineSelect.classList.remove('d-none');
                machineSpan.classList.add('d-none');
                machineSelect.value = row.querySelector('.machine-select').value;
            } else {
                console.error('machineSpan o machineSelect no encontrados.');
            }

            const editBtn = row.querySelector('.edit-btn');
            const trashBtn = row.querySelector('.trash-btn');
            const cancelBtn = row.querySelector('.cancel-btn');
            const saveForm = row.querySelector('.save-form');

            console.log('Botones encontrados:', {
                editBtn,
                trashBtn,
                cancelBtn,
                saveForm
            }); // Verificar si los botones existen

            if (editBtn && trashBtn && cancelBtn && saveForm) {
                editBtn.classList.add('d-none');
                trashBtn.classList.add('d-none');
                cancelBtn.classList.remove('d-none');
                saveForm.classList.remove('d-none');
            } else if (editBtn && cancelBtn && saveForm) {
                editBtn.classList.add('d-none');
                cancelBtn.classList.remove('d-none');
                saveForm.classList.remove('d-none');
            } else {
                console.error('Algunos botones no fueron encontrados correctamente.');
            }

            // Deshabilitar los botones de otras filas
            document.querySelectorAll('#contabilidad-table tbody tr').forEach(tr => {
                if (tr !== row) {
                    const inputs = tr.querySelectorAll('input');
                    inputs.forEach(input => {
                        if (input) {
                            input.setAttribute('disabled', 'true');
                        } else {
                            console.error('Input no encontrado en fila de otras filas.');
                        }
                    });

                    const editBtn = tr.querySelector('.edit-btn');
                    const trashBtn = tr.querySelector('.trash-btn');
                    const cancelBtn = tr.querySelector('.cancel-btn');
                    const saveForm = tr.querySelector('.save-form');

                    if (editBtn) {
                        editBtn.setAttribute('disabled', 'true');
                    }
                    if (trashBtn) {
                        trashBtn.setAttribute('disabled', 'true');
                    }
                    if (cancelBtn) {
                        cancelBtn.classList.add('d-none');
                    }
                    if (saveForm) {
                        saveForm.classList.add('d-none');
                    }
                }
            });

            console.log('Fila actual en edición:', row);

            // Actualizar valores en campos ocultos
            updateHiddenFields(row);

            // Agregar listeners a los inputs para actualizar los campos ocultos en tiempo real
            addInputListeners(row);

            currentEditingRow = row;
        }

        // Resto del código de edición...
    });
</script>
