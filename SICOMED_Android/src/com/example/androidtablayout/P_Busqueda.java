package com.example.androidtablayout;


import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class P_Busqueda extends Activity {
	 
    static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_p_busqueda);
        
        
        final AlertDialog.Builder builder = new AlertDialog.Builder(this);
        final TextView Txt_mensaje =(TextView)findViewById(R.id.Txt1);
        //Localizar los controles
        final EditText Rut_0 = (EditText)findViewById(R.id.edittext);
        final EditText Rut_1 = (EditText)findViewById(R.id.edittext_2);
        final Button btnBuscar = (Button)findViewById(R.id.Btn);
        Rut_1.setMaxLines(1);
                             
       btnBuscar.setOnClickListener(new OnClickListener() {
	            public void onClick(View v) {
	                //Creamos el Intent
	            	final String txtRut = Rut_0.getText().toString() + "-" + Rut_1.getText().toString();
	            	JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, txtRut);
	            	
	            	try {
						if(Ficha_Clinica.getString("_id").equals(txtRut)){
							
			            	Intent intent = new Intent(P_Busqueda.this, TabLayout_Ficha_Clinica.class);
			            	
			            	
			            	//Creamos la informaci�n a pasar entre actividades
			            	Bundle b = new Bundle(); 
			            	//txtRut.getText().toString()
			            	b.putString("RUT", txtRut);
			            	
			            	//A�adimos la informaci�n al intent
			            	intent.putExtras(b);
			            	        	
			            	//Iniciamos la nueva actividad
			                startActivity(intent);
							
						}
					} catch (JSONException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
						
					    builder.setTitle("Error");
					    builder.setMessage("El paciente no se encuentra en la Base de datos\nIngrese Rut existente");
					    builder.setPositiveButton("OK",null);										    							                     		 
					    builder.create();
					    builder.show();

					}
	            	

	            }
	        });
    }
}