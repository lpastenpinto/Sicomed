package com.example.androidtablayout;

import java.io.BufferedReader;
import java.io.DataInputStream;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.zip.GZIPInputStream;

import org.apache.http.Header;
import org.apache.http.HttpEntity;
import org.apache.http.HttpRequest;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpPut;
import org.apache.http.client.methods.HttpUriRequest;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;


import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.util.Log;
import android.widget.ImageView;

public class FuncionesCouch {
	private static final String TAG = "FuncionesCouch";
	public static JSONObject GetFichaClinica(String hostUrl, String databaseName,String docId) {
        
		try {
            HttpGet httpGetRequest = new HttpGet(hostUrl + databaseName + "/" + docId);
            
            JSONObject jsonFicha = EnviarPeticionCouch(httpGetRequest);
            if (jsonFicha != null) {
                return jsonFicha;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }
	
	static JSONObject EnviarPeticionCouch(HttpRequest request_old){
		
		try { 
			
			HttpRequest request = SetEncriptacion(request_old);
			HttpResponse httpResponse = (HttpResponse) new DefaultHttpClient().execute((HttpUriRequest) request);
			HttpEntity entity = httpResponse.getEntity();
		
			if (entity != null) {
				//Leer el contenido del stream
				InputStream input_stream = entity.getContent();
			
				//Convertir contenido del stream en String
				String resultString = Conversor_Stream_String(input_stream);
				input_stream.close();
			
				//Transformar el string en un objeto Json
				JSONObject jsonResult = new JSONObject (resultString);
				return jsonResult;
			}
		} catch (Exception e){
			e.printStackTrace();
		}
		
		return null;
	 }
	
	public static String Conversor_Stream_String(InputStream is){
		
		BufferedReader reader = new BufferedReader(new InputStreamReader(is),8192);
		StringBuilder sb = new StringBuilder();
		String line = null;
		
		try {
			while ((line = reader.readLine()) != null) {
				sb.append(line+"\n");
			}
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			try {
				is.close();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		return sb.toString();
	}


	public static HttpRequest SetEncriptacion(HttpRequest request)  {
	    request.setHeader("Accept", "application/json");
	    request.setHeader("Content-type", "application/json");
	    request.setHeader("Authorization", "Basic bWlndWVsb3N0OmRlZmF1bHQ=");
	    return request;
	}

public static void ActualizarFicha(String hostUrl, String databaseName, JSONObject jsonDoc){
		
		try {
			
			String IdFicha = jsonDoc.getString("_id");
			 HttpPut httpPutRequest = new HttpPut(hostUrl + databaseName + "/" + IdFicha);
			 StringEntity body = new StringEntity(jsonDoc.toString(), "utf8");
			 httpPutRequest.setEntity(body);
	         httpPutRequest.setHeader("Accept", "application/json");
	         httpPutRequest.setHeader("Content-type", "application/json");
	         JSONObject jsonResult = EnviarPeticionCouch(httpPutRequest);
			
	         //return jsonResult.getString("rev");
	         
		} catch (Exception e) {
            e.printStackTrace();
        }
        //return null;
	}
		
public static String GetAttachment(String hostUrl, String databaseName,String docId,String attachId) throws Exception {
	//ImageView imagen_android = (ImageView) findViewById(R.id.imagen_examen);
	URL Url = null;
	String text=null;
	try {
		Url = new URL (hostUrl + databaseName + "/" + docId + "/" + attachId);
		
		HttpURLConnection conn = (HttpURLConnection) Url.openConnection();
		conn.addRequestProperty("Authorization","Basic bWlndWVsb3N0OmRlZmF1bHQ=");
		conn.connect();
		
		
		InputStream is = conn.getInputStream();
		InputStream iss = Url.openStream();                      // Abro InputStream desde URL
		BufferedReader di = new BufferedReader(new InputStreamReader( is ));
		text = di.readLine();
		
		
		/*DataInputStream stream = new DataInputStream(Url.openStream());
		 do {
	            text = stream.readLine();
	            
	         } while (text!=null);*/ 
		
	} catch (Exception e){
		e.printStackTrace();
	}
	return text;		
}
	


public static Bitmap Get_Examen(String hostUrl, String databaseName, String docId, String attachId){
	URL imageUrl = null;
	Bitmap examen;
	try {
		imageUrl = new URL (hostUrl + databaseName + "/" + docId + "/" + attachId);
		
		HttpURLConnection conn = (HttpURLConnection) imageUrl.openConnection();
		conn.addRequestProperty("Authorization","Basic bWlndWVsb3N0OmRlZmF1bHQ=");
		conn.connect();
		
		examen = BitmapFactory.decodeStream(conn.getInputStream());
		
		return examen;
		
		
	} catch (Exception e){
		e.printStackTrace();
	}
	return null;		
}


}	
	


