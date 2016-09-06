package com.example.androidtablayout;


import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.UnknownHostException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.ByteArrayEntity;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicHeader;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.protocol.BasicHttpContext;
import org.apache.http.protocol.HTTP;
import org.apache.http.protocol.HttpContext;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class P_Autenticacion extends Activity {
	static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";

	
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_p_inicio);
        
        
        final AlertDialog.Builder builder = new AlertDialog.Builder(this);
        //Localizar los controles
        final TextView User =(TextView)findViewById(R.id.Txt1);
       
        final EditText txtUser = (EditText)findViewById(R.id.texto1);
        
        final TextView Pass =(TextView)findViewById(R.id.Txt2);
        
        final EditText txtPass = (EditText)findViewById(R.id.texto2);
        
        final Button btnbuscar = (Button)findViewById(R.id.btn);

 
      btnbuscar.setOnClickListener(new OnClickListener() {
	            public void onClick(View v) {	                	            		            	
	            	//Verifica Conexion Internet
	            	boolean bool = Verificar_Conexion_Internet();
	            	if(bool==true){
	            		
	            		final String Rut = txtUser.getText().toString();
		            	JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, Rut);
		            	
		            	try {
							if(Ficha_Clinica.getString("_id").equals(Rut)){
								
								final String Pass = txtPass.getText().toString();
								
								
									if(Ficha_Clinica.getString("password").equals(Pass)){
									
										//Creamos el Intent
											Intent intent_0 = new Intent(P_Autenticacion.this, P_Busqueda.class);
											Bundle b = new Bundle(); 
										//Creamos la informaci�n a pasar entre actividades
											b.putString("rut", Rut);

										//A�adimos la informaci�n al intent
											intent_0.putExtras(b);	            	
										//Iniciamos la nueva actividad
											startActivity(intent_0);
									}else{
										
										
										    builder.setTitle("Error");										
										    builder.setMessage("Contrase�a Incorrecta");
										    builder.setPositiveButton("OK",null);										    							                     		 
										    builder.create();
										    builder.show();

									}
				            	
								
							}else{
								
								    builder.setTitle("Error");
								    builder.setMessage("El Usuario no se encuentra en la Base de datos\nIngrese Usuario existente");
								    builder.setPositiveButton("OK",null);										    							                     		 
								    builder.create();
								    builder.show();
	
							}
						} catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
							
							   builder.setTitle("Error");
							    builder.setMessage("El Usuario no se encuentra en la Base de datos\nIngrese Usuario existente");
							    builder.setPositiveButton("OK",null);										    							                     		 
							    builder.create();
							    builder.show();
						}
     		
	            	}else{
	            		
	            		    builder.setTitle("Error Conexion BD");
						    builder.setMessage("Imposible conectar a Base de datos.\nIntente mas tarde");
						    builder.setPositiveButton("OK",null);										    							                     		 
						    builder.create();
						    builder.show();

	            	}	            		            		            		            		           	            		                
	            }
	        });

    }

    
    
    
    
public  boolean Verificar_Conexion_Internet()
    {
            try {
                    //make a URL to a known source
                    URL url = new URL("http://www.google.com");

                    //abrir coneccion
                    HttpURLConnection urlConnect = (HttpURLConnection)url.openConnection();

                    //intenrar realizar coneccion
                    Object objData = urlConnect.getContent();

            } catch (UnknownHostException e) {
                    // TODO Auto-generated catch block
                    e.printStackTrace();
                    return false;
            }
            catch (IOException e) {
                    // TODO Auto-generated catch block
                    e.printStackTrace();
                    return false;
            }
            return true;
    }

}