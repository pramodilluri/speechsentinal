using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Threading.Tasks;
using System.Net.Http;
using System.Text;
using System.Text.Json;
using System.Configuration;

namespace SentimentAnalysisAPI.Controllers
{
    [ApiController]
    [Route("[controller]")]
    public class AnalyzeController : ControllerBase
    {
        private static readonly HttpClient client = new HttpClient();
        private const string API_KEY = "apiKey";
        private const string URL = "url";
        private const string SUBSCRIPTION_KEY = "Ocp-Apim-Subscription-Key";
        private const string APPLICATION_JSON = "application/json";

        [HttpPost]
        public async Task<JsonDocument> Post(Document doc)
        {
            List<Document> documents = new List<Document>() { doc };
            var requestBody = JsonSerializer.Serialize(documents);
            requestBody = "{\"documents\" : " + requestBody + "}";

            var apiKey = ConfigurationManager.AppSettings[API_KEY];
            var url = ConfigurationManager.AppSettings[URL];

            client.DefaultRequestHeaders.Add(SUBSCRIPTION_KEY, apiKey);

            var content = new StringContent(requestBody, Encoding.UTF8, APPLICATION_JSON);
            var response = await client.PostAsync(url, content);

            var responseMsg = "";
            if (response.IsSuccessStatusCode)
            {
                responseMsg = await response.Content.ReadAsStringAsync();
            }

            return JsonDocument.Parse(responseMsg);
        }

        [HttpGet]
        public Document Get()
        {
            Document doc = new Document
            {
                Id = "1",
                Language = "en",
                Text = "This is a GET call. Please make a POST call to test the sentiment analysis service. :)"
            };

            return doc;
        }
    }
}
