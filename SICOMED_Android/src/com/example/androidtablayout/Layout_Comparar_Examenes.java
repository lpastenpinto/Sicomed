package com.example.androidtablayout;

import android.app.Activity;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.widget.ImageView;

public class Layout_Comparar_Examenes extends Activity{
	
	static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";
	private ImageView imageView_1;
	private ImageView imageView_2;
    private Bitmap Imagen_Examen_1;
    private Bitmap Imagen_Examen_2;
	public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.compara_examenes_layout);
        
        final Bundle bundle = this.getIntent().getExtras(); 
        
        imageView_1 = (ImageView) findViewById(R.id.image_view_1); 
        imageView_2 = (ImageView) findViewById(R.id.image_view_2); 
        
        Imagen_Examen_1 = FuncionesCouch.Get_Examen(HOST, DBNAME, bundle.getString("RUT"),bundle.getString("Ex_1")  );                	
		imageView_1.setImageBitmap(Imagen_Examen_1);
		
        Imagen_Examen_2 = FuncionesCouch.Get_Examen(HOST, DBNAME, bundle.getString("RUT"),bundle.getString("Ex_2")  );                	
		imageView_2.setImageBitmap(Imagen_Examen_2);
	}
	
	public void obtener_imagenes(){}

}
