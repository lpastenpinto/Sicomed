package com.example.androidtablayout;



import java.util.Calendar;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class Datos_personales extends Activity {
	
	static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";
    TextView Rut_t ;
    TextView Nombre_t;
    TextView Apellidos_t;
    TextView Fecha_nac_t;
    TextView Edad_t;
    TextView Sang_t; 
    EditText txtEst;
    EditText txtPeso;
    TextView Ocup_t;
     // o fecha de nacimiento
    TextView Tel_t;
    TextView Dir_t;
    Button btn_edit;
	
    public void onCreate(Bundle savedInstanceState) {
        
    	super.onCreate(savedInstanceState);
        setContentView(R.layout.datos_per);
  
        
        final AlertDialog.Builder builder = new AlertDialog.Builder(this);
        
        //asignar ids a cada elemento del layout
        Rut_t =(TextView)findViewById(R.id.Txt11);
        Nombre_t =(TextView)findViewById(R.id.Txt22);
        Apellidos_t =(TextView)findViewById(R.id.Txt33);
        Fecha_nac_t =(TextView)findViewById(R.id.Txt44);
        Edad_t =(TextView)findViewById(R.id.Txt55);
        Sang_t =(TextView)findViewById(R.id.Txt99); 
        
        txtEst = (EditText)findViewById(R.id.texto6);
        txtEst.setBackgroundColor(Color.WHITE);
        txtEst.setTextColor(Color.BLACK);
        
        txtPeso = (EditText)findViewById(R.id.texto7);
        txtPeso.setBackgroundColor(Color.WHITE);
        txtPeso.setTextColor(Color.BLACK);
        
        
        Ocup_t =(TextView)findViewById(R.id.Txt88);
         // o fecha de nacimiento
        Tel_t =(TextView)findViewById(R.id.Txt101);
        Dir_t =(TextView)findViewById(R.id.Txt111);
        btn_edit = (Button)findViewById(R.id.b_edit);
        //final Button btn_guar = (Button)findViewById(R.id.b_guar);
        btn_edit.setText("Editar");
        
        try {
        	//intentar obtener datos personales para visualizar
	        obtener_datos_pers();
        } catch (JSONException e) {
        	
        	
			// TODO Auto-generated catch block
        	builder.setTitle("Error");
		    builder.setMessage("Imposible Obtener informacion de paciente.\nFormato de Ficha Incorrecto en la BD");
		    builder.setPositiveButton("OK",null);										    							                     		 
		    builder.create();
		    builder.show();
        	
			e.printStackTrace();
		}
        
        btn_edit.setOnClickListener(new OnClickListener() {
            public void onClick(View v) {
            	if(btn_edit.getText().equals("Editar"))
            	{	
            		txtPeso.setEnabled(true);
            	
            		txtEst.setEnabled(true);
					Toast toast=
							Toast.makeText(getApplicationContext(),
									"Listo para editar peso y estatura.", Toast.LENGTH_SHORT);
	 
					toast.show();
            		
            		btn_edit.setText("Guardar");
            	}else{
            		

                    // actualizacion
                    
                	//almacenar los valores nuevos
            		if(!txtPeso.getText().toString().equals("")&&!txtEst.getText().toString().equals(""))
            		{
                	
            				try {
            				
            				
            						guardar_pes_est();

            				
                
            				} catch (JSONException e) {
            			// 	TODO Auto-generated catch block
            			
            						e.printStackTrace();
            			
            						builder.setTitle("Error Conexion BD");
            						builder.setMessage("Imposible editar campos.\nCompruebe conexion a Internet");
            						builder.setPositiveButton("OK",null);										    							                     		 
            						builder.create();
            						builder.show();
            				}
                            			            			            	
            		}else{
							builder.setTitle("Campos vacios");
							builder.setMessage("Alguno de los campos esta vacio. Debe tener ambos campos llenos para poder guardar\nIntente de nuevo");
							builder.setPositiveButton("OK",null);										    							                     		 
							builder.create();
							builder.show();
            			
            			
            		}
            		
            	
            	}
            }
        });

    }
    
    
    
    
    
    
    
    
    public void obtener_datos_pers() throws JSONException{
    	
    	//con bundle se obtiene rut del paciente
    	 final Bundle bundle = this.getIntent().getExtras();
    	 //se obtiene ficha clinica
    	 final JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, bundle.getString("RUT"));
        
    	 //obtencion de cada parametros de datos personales y asignacion a un elemtno del layout
		Rut_t.setText("\t" + Ficha_Clinica.getString("_id")+"\n");
		Nombre_t.setText("\t" + Ficha_Clinica.getString("nombre"));
		Apellidos_t.setText("\t" + Ficha_Clinica.getString("apellido_paterno")+" "+Ficha_Clinica.getString("apellido_materno"));
		Sang_t.setText("\t" + Ficha_Clinica.getString("grupo_sangre"));
		Dir_t.setText("\t" + Ficha_Clinica.getString("direccion"));
		
		
		txtEst.setText(String.valueOf(Ficha_Clinica.getDouble("estatura")));
        txtEst.setEnabled(false);
        txtEst.setBackgroundColor(Color.WHITE);
        txtEst.setTextColor(Color.BLACK);
        
        txtPeso.setText(String.valueOf(Ficha_Clinica.getDouble("peso")));
        txtPeso.setEnabled(false);
        txtPeso.setBackgroundColor(Color.WHITE);
        txtPeso.setTextColor(Color.BLACK);
        //transformar fecha de nacimiento en int para parametro de funcion Calculo_edad()
        int anhio=Integer.parseInt(Ficha_Clinica.getString("nac_year"));
        int mes=Integer.parseInt(Ficha_Clinica.getString("nac_month"));
        int dia=Integer.parseInt(Ficha_Clinica.getString("nac_day"));
        
        
        Edad_t.setText("\t" + Calculo_edad(anhio,mes,dia));
        Ocup_t.setText("\t" + Ficha_Clinica.getString("actividad"));
        Fecha_nac_t.setText("\t" + Ficha_Clinica.getString("nac_day")+"/"+Ficha_Clinica.getString("nac_month")+"/"+Ficha_Clinica.getString("nac_year"));	//fecha nacimiento
        Tel_t.setText("\t" + String.valueOf(Ficha_Clinica.getInt("telefono")));
    	
    }
    
    
    
    public void guardar_pes_est() throws JSONException{
    	 
    	final Bundle bundle = this.getIntent().getExtras();
        final JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, bundle.getString("RUT"));
         //agregar a ficha clinica nuevos valores
		Ficha_Clinica.put("peso", txtPeso.getText());
		Ficha_Clinica.put("estatura",txtEst.getText());
		//actualiza a la base de datos la ficha clinica
		FuncionesCouch.ActualizarFicha(HOST, DBNAME, Ficha_Clinica);    

		txtPeso.setEnabled(false);

		txtEst.setEnabled(false);
		btn_edit.setText("Editar");
		Toast toast=
				Toast.makeText(getApplicationContext(),
						"Guardado con exito", Toast.LENGTH_SHORT);

		toast.show();
    	
    	
    }
    
    
    
    
    
    
    
    public String Calculo_edad (int anhio, int mes , int dia){
    	
    	
    	Calendar c1 = Calendar.getInstance();   	
    	c1.set(c1.get(Calendar.YEAR), c1.get(Calendar.MONTH), c1.get(Calendar.DATE));
    	
    	//Fecha de nacimiento
    	Calendar c2 = Calendar.getInstance();
 
    	c2.set(anhio,mes,dia);
    	
    	//calculo de diferencia de fecha
    	long milis1 = c1.getTimeInMillis();
 
    	long milis2 = c2.getTimeInMillis();
    	long diff = milis1 - milis2;
    	long Days = diff / (24 * 60 * 60 * 1000);
    	//String str = Long.toString(Days);

    	int dias_diferencia = (int)Days;
    	
    	int anhios_act = dias_diferencia/365;
    	int meses_act = (dias_diferencia - (365*anhios_act))/31;
    	
    	String edad_actual = anhios_act + "Años , "+meses_act + " Meses" ;
    	return edad_actual;
    	
    	
    }
    
}
