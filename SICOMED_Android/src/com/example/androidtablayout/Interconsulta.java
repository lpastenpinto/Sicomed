package com.example.androidtablayout;

import java.util.Calendar;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Interconsulta extends Activity {
	static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";
	static TextView Hist_Inter;
	static EditText Inter_edit;
	static EditText Control_edit;
	static EditText Nombre_edit;
	static EditText Espec_DocInter_edit;
	String[] lista_fecha_especialidad;
	String[] fechas_tratamiento_elegir;
	String[] especialidad;
	String fecha_inter;
	String especialidad_inter;
	Spinner fecha_trat_elegir;
	static String txt_Escoger="Escoja especialidad y fecha de la asignacion de Interconsulta";
	
	 
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.inter_layout);  
        final TextView Tit =(TextView)findViewById(R.id.txt);
        
        //asignacion de id a elemtos de layout
        Hist_Inter =(TextView)findViewById(R.id.Hist_inter_txt);
        
        final TextView Inter_txt =(TextView)findViewById(R.id.Inter_txt);  
        Inter_edit = (EditText)findViewById(R.id.Inter_edit);     
     
        final TextView Esp_Inter_txt =(TextView)findViewById(R.id.Esp_int_txt);  
        Espec_DocInter_edit = (EditText)findViewById(R.id.Esp_int_edit);
        
        final Button btn_guard_trat = (Button)findViewById(R.id.b_guard_inter);

        final TextView Nombre_d =(TextView)findViewById(R.id.Nombre_txt);
        Nombre_edit = (EditText)findViewById(R.id.Nombre_edit);
        
        final TextView Contro_inter_txt =(TextView)findViewById(R.id.Control_txt);
        Control_edit = (EditText)findViewById(R.id.Control_edit);


        //agregar spinner
        fecha_trat_elegir = (Spinner)findViewById(R.id.fecha_t);
        
        final Button btn_guard_control = (Button)findViewById(R.id.b_guard_control);
        
        
        btn_guard_control.setEnabled(false);
        Nombre_edit.setEnabled(false);
        Control_edit.setEnabled(false);
        
       try {    	  
		obtener_fechas_esp();
	} catch (JSONException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
		AlertDialog.Builder error_0 = new AlertDialog.Builder(this); 
		error_0.setTitle("Error Conexion BD");
	    error_0.setMessage("Imposible obtener fechas de Interconsultas.\nCompruebe conexion a Internet");
	    error_0.setPositiveButton("OK",null);										    							                     		 
	    error_0.create();
	    error_0.show();
	}
       //adaptador para visualizar en una lista las fechas
        ArrayAdapter<String> adaptador =
            new ArrayAdapter<String>(this,
                android.R.layout.simple_spinner_item, lista_fecha_especialidad);
        
        adaptador.setDropDownViewResource(
                android.R.layout.simple_spinner_dropdown_item);
        
        fecha_trat_elegir.setAdapter(adaptador);
        //obtener historial de interconsultas                                       
        obtener_hist_inter();
                                
        fecha_trat_elegir.setOnItemSelectedListener(
            	new AdapterView.OnItemSelectedListener() {
                    public void onItemSelected(AdapterView<?> parent,
                        android.view.View v, int position, long id) {
                    	if(!lista_fecha_especialidad[position].equals(txt_Escoger)){
                    		fecha_inter=fechas_tratamiento_elegir[position-1];
                    		especialidad_inter=especialidad[position-1];
                            btn_guard_control.setEnabled(true);
                            Nombre_edit.setEnabled(true);
                            Control_edit.setEnabled(true);
                    		
                    	}else if(lista_fecha_especialidad[position].equals(txt_Escoger)){
                    		 Nombre_edit.setEnabled(false);
                            btn_guard_control.setEnabled(false);
                            Control_edit.setEnabled(false);
                    		
                    	}
                    }
             
                    public void onNothingSelected(AdapterView<?> parent) {
                      
                    }
            });
        
        
        
        
        btn_guard_trat.setOnClickListener(new OnClickListener() {
            public void onClick(View v) { 
            	
            	guardar_nuevo_inter();
            	
            }
        });
        
        btn_guard_control.setOnClickListener(new OnClickListener() {
            public void onClick(View v) { 
            	
            	guardar_control_inter();
            	
            }
        });
    }
    
   
    
    
    
    
 public void guardar_nuevo_inter(){
	 
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 Calendar fecha_Actual = Calendar.getInstance();   	
	
 	 if(!Inter_edit.getText().toString().equals("")&&!Espec_DocInter_edit.getText().toString().equals("")){
 		 //insertar 
 		 	JSONArray json_array;
 		 	try {
			
 		 			json_array = Ficha_Clinica.getJSONArray("inter_consulta");
 		 			JSONObject json = new JSONObject();
 		 			json.put("fecha_indicacion",fecha_Actual.get(Calendar.DATE)+"/"+fecha_Actual.get(Calendar.MONTH)+"/"+fecha_Actual.get(Calendar.YEAR) );			
 		 			json.put("motivo", Inter_edit.getText());
 		 			json.put("especialidad", Espec_DocInter_edit.getText());
 		 			json.put("fecha_resultados","En espera...");
 		 			json.put("nombre_doctor","En espera..." );
 		 			json.put("resultados","En espera...");
 		 			json_array.put(json);
			
 		 			FuncionesCouch.ActualizarFicha(HOST, DBNAME, Ficha_Clinica);
 		 		
 		 			Inter_edit.setText("");
 		 			Espec_DocInter_edit.setText("");
 		 			obtener_hist_inter();
				
 		 	       try {    	  
 		 	    	   obtener_fechas_esp();
 		 	 	   } catch (JSONException e) {
 		 	 		   // TODO Auto-generated catch block
 		 	 		   e.printStackTrace();
 		 	 		   AlertDialog.Builder error_0 = new AlertDialog.Builder(this); 
 		 	 		   error_0.setTitle("Error ");
 		 	 		   error_0.setMessage("No se puede obtener fechas de interconsultas\nCompruebe conexion a internet");
 		 	 		   error_0.setPositiveButton("OK",null);										    							                     		 
 		 	 		   error_0.create();
 		 	 		   error_0.show();
 		 	 	   }
 		 	        ArrayAdapter<String> adaptador =
 		 	              new ArrayAdapter<String>(this,
 		 	                  android.R.layout.simple_spinner_item, lista_fecha_especialidad);
 		 	          
 		 	          adaptador.setDropDownViewResource(
 		 	                  android.R.layout.simple_spinner_dropdown_item);
 		 	          
 		 	          fecha_trat_elegir.setAdapter(adaptador);
 						Toast toast=
 								Toast.makeText(getApplicationContext(),
 										"Se agrego nueva Interconsulta con Exito", Toast.LENGTH_SHORT);

 								toast.show();	
 		 	} catch (JSONException e) {
 		 		// TODO Auto-generated catch block
 		 			AlertDialog.Builder error_1 = new AlertDialog.Builder(this); 
 		 			e.printStackTrace();
 		 			error_1.setTitle("Error ");
 		 			error_1.setMessage("Imposible guardar nuevo tratamiento.\nCompruebe conexion a Internet");
 		 			error_1.setPositiveButton("OK",null);										    							                     		 
 		 			error_1.create();
 		 			error_1.show();
 		 	}
			 
 	 }else{
 		 
			AlertDialog.Builder error_11 = new AlertDialog.Builder(this); 
	 			
	 		error_11.setTitle("Campos Vacios ");
	 		error_11.setMessage("Hay campos vacios al ingresar una nueva interconsulta\nLlene todos los campos correctamente e intente guardar de nuevo");
	 		error_11.setPositiveButton("OK",null);										    							                     		 
			error_11.create();
	 		error_11.show();
 		 
 		 
 	 }
 } 
 
 
 
 
 
 
 
 
 
 
 
 
 
 public void obtener_fechas_esp() throws JSONException{
		
		final Bundle bundle = this.getIntent().getExtras();        
	    JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, bundle.getString("RUT"));
	    JSONArray Inter = Ficha_Clinica.getJSONArray("inter_consulta");
 		//visualizar
 		int a =Inter.length();

	    int contador =0;
 		for (int i = 1; i <= a; i++) {
 			
 	        JSONObject jsonObject_Trat = Inter.getJSONObject(i-1);
 	        if(jsonObject_Trat.getString("nombre_doctor").equals("En espera...")){
 	        	//lista_fecha_esp[contador]=jsonObject_Trat.getString("Especialidad")+"/"+jsonObject_Trat.getString("fecha");
 	        	contador=contador+1;
 	        }
 	        	
 		}
 		int x=1;
 		

 		
 		fechas_tratamiento_elegir = new String[contador];
 		especialidad= new String[contador];
	    lista_fecha_especialidad = new String[contador+1];
	    lista_fecha_especialidad[0]=txt_Escoger;
 		for (int i = 1; i <= a; i++) {
 			
 	        JSONObject jsonObject_Trat = Inter.getJSONObject(i-1);
 	        if(jsonObject_Trat.getString("nombre_doctor").equals("En espera...")){
 	        	especialidad[x-1]=jsonObject_Trat.getString("especialidad");
 	        	fechas_tratamiento_elegir[x-1]=jsonObject_Trat.getString("fecha_indicacion");
 	        	lista_fecha_especialidad[x]=jsonObject_Trat.getString("especialidad")+"-"+jsonObject_Trat.getString("fecha_indicacion");
 	        	x=x+1;
 	        }
 	        	
 		}

	  }
 
 
 
 
 
 
 
 
 
 public void obtener_hist_inter(){
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 
	 String fecha_indicacion = null;
	 String fecha_resultados=null;
 	 String motivo = null;
 	 String resultados = null;
 	
 	 String especialidad = null;
 	String Nombre_doctor = null;
 	 try {
 
 		JSONArray Inter = Ficha_Clinica.getJSONArray("inter_consulta");
 		//visualizar
 		int a =Inter.length();
 		String text_Trat ="";
 		for (int i = a-1; i >=0; i--) {
 			
 	        JSONObject jsonObject_Trat = Inter.getJSONObject(i);
 	        
 	        fecha_indicacion = jsonObject_Trat.getString("fecha_indicacion");
 	        
 	        resultados = jsonObject_Trat.getString("resultados");
 	       
            especialidad=jsonObject_Trat.getString("especialidad");
            
            Nombre_doctor=jsonObject_Trat.getString("nombre_doctor");
            
            fecha_resultados=jsonObject_Trat.getString("fecha_resultados");
            
            motivo=jsonObject_Trat.getString("motivo");
            
            
            
 	        text_Trat=text_Trat+"Fecha en que se asigno interconsulta:\n"+fecha_indicacion+"\nMotivo de Interconsulta\n"+motivo+"\nEspecialidad doctor:\n"+especialidad+"\nFecha resultados:\n"+fecha_resultados+"\nNombre Doctor:\n"+Nombre_doctor+"\nResultados:\n"+resultados+"\n\n\n\n\n";
 
 		}
 		Hist_Inter.setText(text_Trat);
			
		} catch (JSONException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
			AlertDialog.Builder error_2 = new AlertDialog.Builder(this); 
			error_2.setTitle("Error Conexion BD");
		    error_2.setMessage("Imposible Obtener Historial de Interconsultas.\nCompruebe conexion a Internet");
		    error_2.setPositiveButton("OK",null);										    							                     		 
		    error_2.create();
		    error_2.show();

		}
		
 	
	 
	 
 }
 
 
 
 
 
 
 
 
 
 
 
 
 public void guardar_control_inter(){
	 
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 
	 String fecha = null;
	 String especialidad=null;
	 Calendar fecha_actual =Calendar.getInstance();
 	 
	 if(!Nombre_edit.getText().toString().equals("")&&!Control_edit.getText().toString().equals(""))
	 {	 
		 try {
 		 
			 JSONArray Inter_consulta = Ficha_Clinica.getJSONArray("inter_consulta");
			 //	visualizar
			 int a =Inter_consulta.length();
 	
			 for (int i = 0; i < a; i++) {
 			
				 JSONObject jsonObject_Trat = Inter_consulta.getJSONObject(i);
				 fecha = jsonObject_Trat.getString("fecha_indicacion");
				 especialidad=jsonObject_Trat.getString("especialidad");
 	        
				 if((fecha.equals(fecha_inter))&&(especialidad.equals(especialidad_inter))){
 	        	
					 	
					 	jsonObject_Trat.put("nombre_doctor", Nombre_edit.getText());
					 	jsonObject_Trat.put("resultados", Control_edit.getText());
					 	jsonObject_Trat.put("fecha_resultados",fecha_actual.get(Calendar.DATE)+"/"+fecha_actual.get(Calendar.MONTH)+"/"+fecha_actual.get(Calendar.YEAR) );			
					 	
					 	FuncionesCouch.ActualizarFicha(HOST, DBNAME, Ficha_Clinica);
 				
				 	}				  	        	       	      
			 	}
				
				
				 Control_edit.setText("");
				 Nombre_edit.setText("");
				 obtener_hist_inter();
				 try {
					obtener_fechas_esp();
				} catch (JSONException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				 
		        ArrayAdapter<String> adaptador =
		                new ArrayAdapter<String>(this,
		                    android.R.layout.simple_spinner_item, lista_fecha_especialidad);
		            
		            adaptador.setDropDownViewResource(
		                    android.R.layout.simple_spinner_dropdown_item);
		            
		            fecha_trat_elegir.setAdapter(adaptador);
		            Toast toast=
		    				Toast.makeText(getApplicationContext(),
		    						"Se agrego resultado de interconsulta con Exito", Toast.LENGTH_SHORT);

		    				toast.show();    
		 } catch (JSONException e1) {
			// TODO Auto-generated catch block
			 	e1.printStackTrace();
			 	AlertDialog.Builder error_3 = new AlertDialog.Builder(this); 
			 	error_3.setTitle("Error Conexion BD");
			 	error_3.setMessage("Imposible guardar control de tratamiento.\nCompruebe conexion a Internet");
			 	error_3.setPositiveButton("OK",null);										    							                     		 
			 	error_3.create();
			 	error_3.show();

		 	}
		

	 }else{
		 
		 	AlertDialog.Builder error_31 = new AlertDialog.Builder(this); 
		 	error_31.setTitle("Campos Vacios");
		 	error_31.setMessage("Imposible Guardar. El campo Nombre del docto o Resultados estan vacios. \nLLene correctamente y vuelva a Intentar ");
		 	error_31.setPositiveButton("OK",null);										    							                     		 
		 	error_31.create();
		 	error_31.show();		 		 			 		 		
	 }
 }   
 
}