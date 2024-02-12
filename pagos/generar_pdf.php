<?php
include '../conexion/conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $idOrdenPago = $_GET['id'];

    // Consulta para obtener datos de la orden de pago y detalles del proveedor, cuentas y cuenta proveedor asociadas
    $sql = "SELECT op.ID_ORDEN_PAGO, op.ID_PROVEEDOR, p.NOMBRE AS NOMBRE_PROVEEDOR, op.LUGAR, op.FECHA_ORDEN, op.MONTO_TOTAL, op.NUMERO_CUENTA, op.TIPO_CUENTA, op.CONCEPTO, op.SOLICITANTE, op.BANCO
    FROM tbl_orden_pago op
    LEFT JOIN tbl_proveedores p ON op.ID_PROVEEDOR = p.ID_PROVEEDOR
    WHERE op.ID_ORDEN_PAGO = $idOrdenPago";



    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Obtener la fecha de la orden de pago
        $fechaOrdenPago = $row["FECHA_ORDEN"];

        // Obtener el nombre del proveedor
        $proveedorNombre = $row["NOMBRE_PROVEEDOR"];
       

        // Crear una instancia de Dompdf
        require_once '../dompdf_2-0-3/dompdf/autoload.inc.php';
        $dompdf = new Dompdf\Dompdf();

        // Formatear la fecha en español
        $fechaFormateada = null;
        if (!is_null($fechaOrdenPago)) {
            $fechaFormateada = new DateTime($fechaOrdenPago, new DateTimeZone('America/Tegucigalpa'));
            $fechaFormateada = $fechaFormateada->format('d \d\e F \d\e Y');
        } else {
            $fechaFormateada = "Fecha no disponible";
        }

        

        // Contenido HTML para el PDF con cambio en el tamaño del texto
        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px; /* Tamaño del texto para párrafos */
                }
                h2 {
                    font-size: 16px; /* Tamaño del texto para h2 */
                    text-align: center; /* Centrar el texto */
                }
                p {
                    font-size: 12px; /* Tamaño del texto para párrafos */
                }
                /* Agrega el estilo necesario para tu PDF aquí */
                .logo {
                    position: absolute;
                    top: 20px;
                    rigth: 200px;
                    width: 100px; /* Ajusta el ancho según tu necesidad */
                    height: auto;
                }
                .cuenta-info {
                    margin-right: 20px; /* Ajusta el margen derecho según tu necesidad */
                }
                .signature {
                    text-align: center; /* Centra el contenido */
                    margin-top: 20px; /* Ajusta el margen superior según tu necesidad */
                }
                .exclusive-text {
                    text-align: center; /* Centra el texto */
                    color: red; /* Color rojo */
                }
                .cuenta {
                    margin-right: 150px; /* Ajusta el margen derecho según tu necesidad */
                }
                .container {
                    width: 100%;
                    text-align: center; /* Alinea el contenido al centro */
                }
                
                .container p {
                    margin: 0; /* Elimina el margen predeterminado del párrafo */
                }
                
                .container p span {
                    display: inline-block; /* Permite que los elementos <span> se muestren en línea */
                    margin: 0 20px; /* Ajusta el espacio horizontal entre los elementos <span> */
                }
                
            </style>
        </head>
        <body>
        
        <img src="data:image/jpeg;base64,'. base64_encode(file_get_contents('../imagen/IHCIS.jpg')) .'" alt="Logo 1" style="width: 60px; position: absolute; top: 0; right: 0; margin-right: 80px;">
            <h2>INSTITUTO HONDUREÑO DE CULTURA INTERAMERICANA</h2>
            <h2>SOLICITUD DE TRANSFERENCIA L.</h2>

            <div class="form-section">
                <p><strong>Lugar y Fecha:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $row['LUGAR'] . '&nbsp;&nbsp;&nbsp;&nbsp; ' . $fechaFormateada.' <span style="margin-left:-250px;">__________________________________________________________________________</span></p>
                <p><strong>A Favor:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . $proveedorNombre . '<span style="margin-left:-62px;">__________________________________________________________________________</span></p>
                <p><strong>Cantidad a transferir: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;L.&nbsp;</strong> ' . $row["MONTO_TOTAL"] . '<span style="margin-left:-54px;">___________________________________________________________________________</span></p>
                <p><strong>Número de cuenta :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>' . $row['NUMERO_CUENTA'] . '<span style="margin-left:-30px;">_______________________________</span>&nbsp;&nbsp;&nbsp;| Tipo de cuenta: &nbsp;&nbsp;&nbsp;&nbsp;' . $row['TIPO_CUENTA'] . '<span style="margin-left:-45px;">____________________________</span></p>
                <p><strong>Banco :</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . $row['BANCO'] . '<span style="margin-left:-52px;">___________________________________________________________________________</span></p>
                <p><strong>Concepto de la solicitud :<br></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Compra de ' . $row["CONCEPTO"] . '<span style="margin-left:155px;">__________________________________________________________________________</span>
                <span style="margin-left:153px;">__________________________________________________________________________</span>
                <span style="margin-left:153px;">__________________________________________________________________________</span>
                <span style="margin-left:153px;">__________________________________________________________________________</span>
                <span style="margin-left:153px;">__________________________________________________________________________</span></p>
                <br>
                <p><strong>Nombre del solicitante:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $row["SOLICITANTE"].'<span style="margin-left:-55px;">_________________________________________________________________________</span></p>

                <br><br>
                
                <div class="signature" style="display: flex; justify-content: center;">
                <p>
                <span style="margin-right:61px;">__________________________________________</span> <span>___________________________________</span>
              </p>
              <div class="signer" style="display: inline-block; margin-right: 200px;">Firma supervisor de solicitante</div>
              <div class="signer" style="display: inline-block;">Firma departamento solicitante</div>
                </div>
                <br><br><br>
                
                <div style="display: flex; flex-direction: column;">
                   <p><strong>Observaciones:</strong> ____________________________________________________________________________________</p>
                   <p style="margin-left: 94px;">____________________________________________________________________________________</p>
                </div>
            

                <div class="signature" style="justify-content: center;">
                    <div class="signature-line"></div>
                </div>
                <br><br>
                <div class="signature">
                 <p>___________________________________________________________________</p>
                 <div class="signer">Contador General</div>
               </div>
               <br><br>
                <p><strong>Fecha de remisión a la administración:</strong> ________________________________________________________________</p>
                <br>
                <p class="exclusive-text">EXCLUSIVO PARA CONTABILIDAD</p>

                <p class="documentation-text" style="display: inline-block;">Documentación soporte de acuerdo a política: 
                <span style="margin-left: 80px;">
                    <span class="options">
                        
                        <span style="margin-right: -40px; color: red; display: inline-block; width: 20px; height: 20px; border: 1px solid black; text-align: center; line-height: 20px;"></span>
                        <span>SI</span>
                    </span>
                    <span class="options" style="margin-left: 60px;">
                       
                        <span style="margin-right: -50px; color: red; display: inline-block; width: 20px; height: 20px; border: 1px solid black; text-align: center; line-height: 20px;"></span>
                        <span>NO</span>
                    </span>
                </span>
            </p>
            <br><br><br>
            <div class="signature">
            <div class="container">
               <p>
                 <span style="margin-right:71px;">____________________________________________</span> <span>____________________________________</span>
               </p>
          </div>
        
            <div class="signer" style="margin-left:-5px;"><span class="cuenta">Revisión y Aprobación de Cheque / Transferencia</span>Autorización de Cheque / Transferencia</div>
                <div class="signer" style="margin-left:-5px;"><span class="cuenta">Sub Dirección Ejecutiva / Dirección Ejecutiva</span>Sub Dirección Ejecutiva / Dirección Ejecutiva</div>
            </div>

                
            </div>
        </body>
        </html>';

        // Cargar el contenido HTML al Dompdf
        $dompdf->loadHtml($html);

        // Establecer el tamaño del papel y la orientación
        $dompdf->setPaper('letter', 'portrait');

        // Establece la base de la URL para las imágenes
        $dompdf->setBasePath('../imagen/');

        // Renderizar el PDF
        $dompdf->render();

        // Mostrar el PDF en el navegador antes de descargarlo
        $dompdf->stream('solicitud_transferencia.pdf', array('Attachment' => 0));
    } else {
        echo "No se encontraron datos de la orden de compra.";
    }
} else {
    echo "ID de orden de compra no proporcionado.";
}

$conn->close();
?>
