package com.example.quocchi.shipper_app;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.BaseExpandableListAdapter;
import android.widget.Button;
import android.widget.ExpandableListView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.RequestQueue;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.android.volley.Request.*;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.security.KeyManagementException;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.security.cert.X509Certificate;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Map;

import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.SSLSession;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class History_Activity extends AppCompatActivity {

//    ListView lvHistory;
    //ArrayList<History> arrayHistory;

    private ArrayList<History> data = new ArrayList<History>();

    ExpandableListView expandableListView;
    List<NameStore> listContact = new ArrayList<NameStore>();
    List<String> listdataHeader = new ArrayList<String>();
    List<String> list = new ArrayList<String>();
    HashMap<String,ArrayList<History>> listdataChild = new HashMap<String,ArrayList<History>>();

    CustomExpandableListView customExpandableListView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history);

        expandableListView = (ExpandableListView) findViewById(R.id.expandableListView);

        ArrayList<History> store_a = new ArrayList<History>();
        store_a.add(new History("math",1));
        store_a.add(new History("math1",1));
        store_a.add(new History("math2",1));

        ArrayList<History> store_b = new ArrayList<History>();
        store_b.add(new History("english",2));
        store_b.add(new History("english1",2));
        store_b.add(new History("english2",2));

        ArrayList<History> store_c = new ArrayList<History>();
        store_c.add(new History("gaphic",3));
        store_c.add(new History("gaphic1",3));
        store_c.add(new History("gaphic2",3));

        Log.w("List child ", listContact.toString());

        getNameStore("http://192.168.0.132:8000/api/shipper/showAllStoreOrder");

        Log.w("List Header ", listdataHeader.toString());
//        lvHistory = (ListView) findViewById(R.id.list_history);
//        arrayHistory = new ArrayList<History>();
//
//
//        arrayHistory.add(new History("math",1));
//        arrayHistory.add(new History("history",1));
//        arrayHistory.add(new History("van hoc",1));
//
//        ArrayAdapter adapter = new ArrayAdapter(History_Activity.this, android.R.layout.simple_list_item_1, arrayHistory);
//
//        lvHistory.setAdapter(adapter);
//
//        lvHistory.setOnItemClickListener(new AdapterView.OnItemClickListener() {
//            @Override
//            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
//                Toast.makeText(History_Activity.this,arrayHistory.get(position).getA(),Toast.LENGTH_SHORT).show();
//
//            }
//        });


    }

    private void getNameStore(String url){
        RequestQueue requestQueue = Volley.newRequestQueue(this);


        StringRequest stringRequest = new StringRequest(com.android.volley.Request.Method.POST, url, new com.android.volley.Response.Listener<String>() {
            @Override
            public void onResponse(String response) {


                    final String response1 = response;
                    Log.w("List Header Out", listdataHeader.toString());
                    History_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            try{
                                JSONObject Jobject = new JSONObject(response1);
                                JSONArray Jarray = Jobject.getJSONArray("data");
                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);

                                    listdataHeader.add(object.getString("nameStore"));
                                }

                                list = listdataHeader;
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });


                    //Toast.makeText(History_Activity.this,"OK CON TETE",Toast.LENGTH_SHORT).show();

            }
        }, new com.android.volley.Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("your_input","your_value");
                return super.getParams();
            }
        };

        requestQueue.add(stringRequest);

    }

    public class CustomExpandableListView extends BaseExpandableListAdapter {

        Context context;
        List<String> listHeader;
        HashMap<String,ArrayList<History>> listChild;

        public CustomExpandableListView(Context context, List<String> listHeader, HashMap<String, ArrayList<History>> listChild) {
            this.context = context;
            this.listHeader = listHeader;
            this.listChild = listChild;
        }

        @Override
        public int getGroupCount() {
            return listHeader.size();
        }

        @Override
        public int getChildrenCount(int groupPosition) {
            return listChild.get(listHeader.get(groupPosition)).size();
        }

        @Override
        public Object getGroup(int groupPosition) {
            return listHeader.get(groupPosition);
        }

        @Override
        public Object getChild(int groupPosition, int childPosition) {
            return listChild.get(listHeader.get(groupPosition)).get(childPosition);
        }

        @Override
        public long getGroupId(int groupPosition) {
            return groupPosition;
        }

        @Override
        public long getChildId(int groupPosition, int childPosition) {
            return childPosition;
        }

        @Override
        public boolean hasStableIds() {
            return false;
        }

        @Override
        public View getGroupView(int groupPosition, boolean isExpanded, View convertView, ViewGroup parent) {
            String headerTitle = (String) getGroup(groupPosition);

            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_view,null);
            TextView txtheader = (TextView) convertView.findViewById(R.id.txt_history_header);
            txtheader.setText(headerTitle);

            return convertView;
        }

        @Override
        public View getChildView(int groupPosition, int childPosition, boolean isLastChild, View convertView, ViewGroup parent) {
            History test = (History) getChild(groupPosition,childPosition);

            //History a = listChild.get(listHeader.get(groupPosition));
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_child_view,null);

            TextView txta = (TextView) convertView.findViewById(R.id.txt_a);
            TextView txtb = (TextView) convertView.findViewById(R.id.txt_b);

            txta.setText( test.getA().toString());
            txtb.setText( test.getA().toString());


            return convertView;
        }

        @Override
        public boolean isChildSelectable(int groupPosition, int childPosition) {
            return true;
        }
    }

    private class HistoryAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<History> arrayOrder;

        public HistoryAdapter(Context context, int layout, List<History> orderList){
            myContext = context;
            myLayout = layout;
            arrayOrder = orderList;
        }

        @Override
        public int getCount() {
            return arrayOrder.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            //TextView list_item_text = (TextView) convertView.findViewById(R.id.list_item_text);

            final int vitri = position;

//            list_item_text.setText(data.get(position).getA());
//            Button list_item_btn = (Button) convertView.findViewById(R.id.list_item_btn);
//
//            list_item_btn.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View view) {
//                    Toast.makeText(Order_Activity.this,data.get(vitri).getA(),Toast.LENGTH_SHORT).show();
//                }
//            });

            return convertView;
        }
    }


    private class History{
        private String a;
        private int b;

        History(String a, int b){
            this.a = a;
            this.b = b;
        }


        public String getA() {
            return a;
        }

        public void setA(String a) {
            this.a = a;
        }
    }

    private class NameStore{
        private int id_store;
        private String name_store;
        public NameStore(int id_store, String name_store) {
            this.id_store = id_store;
            this.name_store = name_store;
        }

        public int getId_store() {
            return id_store;
        }

        public void setId_store(int id_store) {
            this.id_store = id_store;
        }

        public String getName_store() {
            return name_store;
        }

        public void setName_store(String name_store) {
            this.name_store = name_store;
        }

    }
}

class HttpsTrustManager implements X509TrustManager {

    private static TrustManager[] trustManagers;
    private static final X509Certificate[] _AcceptedIssuers = new X509Certificate[]{};

    @Override
    public void checkClientTrusted(
            java.security.cert.X509Certificate[] x509Certificates, String s)
            throws java.security.cert.CertificateException {

    }

    @Override
    public void checkServerTrusted(
            java.security.cert.X509Certificate[] x509Certificates, String s)
            throws java.security.cert.CertificateException {

    }

    public boolean isClientTrusted(X509Certificate[] chain) {
        return true;
    }

    public boolean isServerTrusted(X509Certificate[] chain) {
        return true;
    }

    @Override
    public X509Certificate[] getAcceptedIssuers() {
        return _AcceptedIssuers;
    }

    public static void allowAllSSL() {
        HttpsURLConnection.setDefaultHostnameVerifier(new HostnameVerifier() {

            @Override
            public boolean verify(String arg0, SSLSession arg1) {
                return true;
            }

        });

        SSLContext context = null;
        if (trustManagers == null) {
            trustManagers = new TrustManager[]{new HttpsTrustManager()};
        }

        try {
            context = SSLContext.getInstance("TLS");
            context.init(null, trustManagers, new SecureRandom());
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        } catch (KeyManagementException e) {
            e.printStackTrace();
        }

        HttpsURLConnection.setDefaultSSLSocketFactory(context
                .getSocketFactory());
    }

}
