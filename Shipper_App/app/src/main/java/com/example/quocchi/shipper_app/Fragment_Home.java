package com.example.quocchi.shipper_app;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.Timer;
import java.util.TimerTask;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Fragment_Home extends Fragment {
    private View mRootView;
    private EditText search;

    private Button btn_done_search;

    private String hostname = "luxexpress.cf";
    private String token = Login_Token.token;

    private CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    private OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();


    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        mRootView = inflater.inflate(R.layout.fragment_home, container, false);
        //initUI();


        search = (EditText) mRootView.findViewById(R.id.search);
        btn_done_search = (Button) mRootView.findViewById(R.id.btn_done_search);

        btn_done_search.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                send_post();
            }
        });


        return mRootView;
    }

    private void send_post() {

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("bill_of_lading", search.getText().toString())
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/shipper/searchBilloflading")
                .post(requestBody)
                .addHeader("Authorization", "Bearer " + token)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();
                Log.w("searchsend: ", yourResponse.toString());
                if (response.isSuccessful()) {
                    if (getActivity() != null) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {


                                JSONObject Jobject = null;
                                Log.w("searchsend true", yourResponse.toString());
                                try {
                                    Jobject = new JSONObject(yourResponse);
                                    JSONObject Jarray = Jobject.getJSONObject("data");

                                    Log.w("abcffffgggg", yourResponse);
                                    Intent intent = new Intent(getActivity(), Search_Activity.class);
                                    intent.putExtra("search_text", search.getText().toString());
                                    startActivity(intent);

                                } catch (JSONException e) {
                                    Log.w("searchsend false fragment", e.toString());
                                    Toast.makeText(getActivity(), "Hiện tại không có đơn hàng nào: ", Toast.LENGTH_SHORT).show();
                                    e.printStackTrace();

                                }
                            }
                        });
                    }

                } else {
                    Log.w("searchsend error", yourResponse.toString());
                }

            }
        });
    }


}
